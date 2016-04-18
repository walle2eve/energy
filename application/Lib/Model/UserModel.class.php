<?php
class UserModel extends Model{
  public function addUser($login_name,$login_pwd,$user_kind,$org_id){
	  $is_user = false;
	  //校验用户名是否已经存在
	  $is_user = $this->where("login_name = %s",$login_name)->getField('login_name');
	  
	  if($is_user)return array('errno'=>201,'errtitle'=>'用户名已经存在！');
	  
	  $data['login_name'] = strtolower($login_name);
	  $data['login_pwd'] = md5($login_pwd);
	  $data['user_kind'] = $user_kind;
	  $data['org_id'] = $org_id;
	  $data['update_time'] = date('Y-m-d H:i:s');
	  $return  = $this->add($data);
	  
	  if($return){
		  return array('errno'=>0,'errtitle'=>'账号添加成功！');
	  }
	  return array('errno'=>3,'errtitle'=>'账号添加失败！');
  }
  public function login($login_name,$login_pwd) {
	  if(!$login_name||!$login_pwd)Return array('errno'=>9,'errtitle'=>'用户名和密码不能为空~');
	  $map['login_name'] = $login_name;
	  $user_info = $this->where($map)->find();
	  //echo M()->getlastsql();exit();
	  if(empty($user_info)){Return array('errno'=>1,'errtitle'=>'用户名不存在');}
	  if(0==$user_info['status']){Return array('errno'=>2,'errtitle'=>'用户已被禁止登录，如需恢复，请咨询客服解决');}
	  if(md5($login_pwd)!=$user_info['login_pwd']){Return array('errno'=>3,'errtitle'=>'密码错误，请重新输入');}

	  $data['last_login_time'] = date('Y-m-d H:i:s');
	  $data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
	  $data['login_count'] = $user_info['login_count'] + 1;
	  $this->where('user_id='.$user_info['user_id'])->save($data);
	  return array('errno'=>0,'userinfo'=>$user_info);
  }

  //修改密码
  public function editPass() {
	  $pass = trim($_POST['oldpass']);
	  $newpass = trim($_POST['newpass']);
	  $repass = trim($_POST['repass']);
	  if(!$pass){Return array('errno'=>1,'errtitle'=>'请输入原密码！');}
	  if(!$newpass){Return array('errno'=>2,'errtitle'=>'请输入新密码！');}
	  if(!$repass){Return array('errno'=>3,'errtitle'=>'请再次输入新密码！');}
	  if(strlen($newpass)>16){Return array('errno'=>5,'errtitle'=>'密码长度请不要大于16位！');}
	  if($repass!==$newpass)Return array('errno'=>4,'errtitle'=>'两次密码输入不一致，请重新输入！');

		$login_name = session('login_name');
	  if(!$login_name)Return array('errno'=>9,'errtitle'=>'您的登录状态有误，请退出重新登录！');
	  $user_id = $this->where(array('login_name'=>$login_name,'login_pwd'=>md5($pass)))->getField('user_id');
	  if(!$user_id)Return array('errno'=>8,'errtitle'=>'原密码错误！');
	  Return $this->where('user_id = '.$user_id)->setField(array('login_pwd'=>md5($newpass)));
  }
  //设置用户状态
  public function setUserStatus($uid) {
      
	  if(!$uid){
		  return array('errno'=>1,'errtitle'=>'参数错误！');
	  }
	  $userinfo = $this->getUserInfoAll($uid);
	  
	  if(!$userinfo) return array('errno'=>21,'errtitle'=>'用户信息错误！');

	  $status = $userinfo['status'] == 1 ? 0 : 1;
	  
	  $return = $this->where('user_id = %d',$uid)->setField('status',$status);
	  //echo M()->getlastsql();
	  $status = $userinfo['status'] == 1 ? '<font color="red">禁用</font>' : '<font color="green">启用</font>';
	  
	  if(!$return){
		 return array('errno'=>232,'errtitle'=>'用户['.$userinfo['login_name'].']启用状态设置失败，请稍后重试'); 
	  }
	  return array('errno'=>0,'errtitle'=>'用户['.$userinfo['login_name'].']启用状态已设置为：'.$status .'。下次登录生效！','data'=>$status);
  }
  
  //修改用户信息
  public function editUserInfo($userinfo){
  	
  	foreach($userinfo as $key=>$val){
  		$userinfo[$key] = addslashes($val);
  	}
	$userinfo['update_time'] = date('Y-m-d H:i:s');
  	$return = $this->where('user_id = %d',session('user_id'))->save($userinfo);
  	if($return === false)return array('errno'=>2,'errtitle'=>'修改失败！');
  	return array('errno'=>0);
  }
  //重置密码
  public function resetPass($login_name = '') {
	  $newpass = trim($_POST['newpass']);
	  $repass = trim($_POST['repass']);
	  if(!$newpass){Return array('errno'=>2,'errtitle'=>'请输入新密码！');}
	  if(!$repass){Return array('errno'=>3,'errtitle'=>'请再次输入新密码！');}
	  if(strlen($newpass)>16){Return array('errno'=>5,'errtitle'=>'密码长度请不要大于16位！');}
	  if($repass!==$newpass)Return array('errno'=>4,'errtitle'=>'两次密码输入不一致，请重新输入！');

	  if(!$login_name)Return array('errno'=>9,'errtitle'=>'您要重置密码的用户不可用');
	  $user_id = $this->where(array('login_name'=>$login_name))->getField('user_id');
	  if(!$user_id)Return array('errno'=>8,'errtitle'=>'没有这个用户');
	  Return $this->where('user_id = '.$user_id)->setField(array('login_pwd'=>md5($newpass)));
  }
  //查看用户
  
  public function getUserInfo($org_id = 0){
	if(empty($org_id) || $org_id == 110000 || $org_id == 110100)
		return array('errno'=>1,'errtitle'=>'参数错误');
	$infos = $this->where('org_id = '.$org_id.'')->select();
	if(empty($infos)){
		return array('errno'=>2,'errtitle'=>'参数错误，没找到这个用户');
	}
	foreach($infos as &$info){
		if($info['user_kind'] == '301020'){
			$info['user_type'] = '区县用户';
			$info['unit_name'] = M('town')->where('town_id = '.$org_id)->getField('town_name');
		}elseif($info['user_kind'] == '301030' OR $info['user_kind'] == '301040'){
			$info['user_type'] = '学校用户';
			$info['unit_name'] = M('school')->where('school_id = '.$org_id)->getField('school_name');
		}
	}
	return $infos;
  }

  //查看用户其他信息
  public function getUserInfoAll($user_id=0){
	if(empty($user_id) || $user_id == 0)
		return array('errno'=>1,'errtitle'=>'参数错误');

	$info = $this->where('user_id = %d',$user_id)->find();

	if(empty($info)){
		return array('errno'=>2,'errtitle'=>'用户信息调取失败！');
	}
	return $info;  
  }
  
 }
?>