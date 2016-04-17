<?php
class AjaxAction extends Action {
	/***
	*	errno:		错误代码
	*	errtitle:	错误描述
	*	data:		返回数据
	*/
	public function _initialize() {
		if(!IS_AJAX)$this->error('请求不合法！');
		$user_id = session('user_id');
		if(!$user_id)$this->returnAjaxMsg(101,'请登录后进行操作！');
    }
	//学校下拉菜单
	public function getSchoolSelect(){
		$town_id = I('town_id',110000);
		$school_type = I('school_type');
		$schoolSelect = D('School')->getSchoolSelect($town_id,0,$school_type);
		if(!empty($schoolSelect))$this->returnAjaxMsg(0,'',$schoolSelect);
		else $this->returnAjaxMsg(1,'学校列表为空');
	}
	//学校类型，学校代码
	public function getSchoolOtherInfo(){
		$school_id = I('school_id');
		$schoolInfo = D('School')->getSchoolOtherInfo($school_id);
		if(!empty($schoolInfo))$this->returnAjaxMsg(0,'',$schoolInfo);
		else $this->returnAjaxMsg(1,'学校错误');
	}//
	//设置用户启用状态 2016-04-17
	public function setUserStatus(){
		$uid = I('id');
		$user_id = session('user_id');
		if($uid == $user_id){
		//	$return = array('errno'=>234,'errtitle'=>'您不能');
		}
		$return  = D('User')->setUserStatus($uid);
	
		$this->ajaxReturn($return);
	}
	//根据用户类别获取用户有权限管理的单位（高校和中小学幼儿园以及区县等）
	public function getOrgs(){
		$user_kind = I('user_kind');
		
		$user_id = session('user_id');
		$user_info = D('User')->getUserInfoAll($user_id);
		//print_r($user_info);
		//echo M()->getlastsql();
		$error = 0;
		switch($user_kind){
			case 301010:
				 if($user_info['user_kind'] != 301010){
					 $error = 1;
					 break;
				 }
				 //添加市级用户
				 $options = array(array('org_id'=>110000,'org_name'=>'市级用户'));
			 break;
			 case 301020:
				 if(!in_array($user_info['user_kind'],array(301010,301020))){
					 $error = 1;
					 break;
				 }
				 if($user_info['user_kind'] == 301010){
					 $where = 'town_id > 110100';
				 }else{
					 $where = 'town_id = '. $user_info['org_id'];
				 }
				 $options = D('Town')->field('town_id AS org_id,town_name AS org_name')->where($where)->select();
			 break;
			 //高校用户
			 case 301030:
				 if($user_info['user_kind'] != 301010){
					 $error = 1;
					 break;
				 }
				 $where = 'town_id = '. $user_info['org_id'];
				 $options = D('School')->field('school_id AS org_id,school_name AS org_name')->where($where)->select();
			 break;
			 //中小学幼儿园用户
			 case 301040:
				 if(!in_array($user_info['user_kind'],array(301010,301020))){
					 $error = 1;
					 break;
				 }
				 if($user_info['user_kind'] == 301010){
					 $where = 'town_id > 110100';
				 }else{
					 $where = 'town_id = '. $user_info['org_id'];
				 }
				 $options = D('School')->field('school_id AS org_id,school_name AS org_name')->where($where)->select();
			 break;
			 default:
				$error =1;
			 break;
		}
		if($error != 0) return $this->returnAjaxMsg(1,'您没有权限操作当前类型用户！');
		
		$optionstr = '';
		
		foreach($options as $row){
			$optionstr .= "<option value='" . $row['org_id'] . "'>" . $row['org_name'] . "</option>";
		}
		
		if($optionstr != ''){
			$this->returnAjaxMsg(0,'',$optionstr);
		}else{
			$this->returnAjaxMsg(23,'数据为空');
		}
	}
	private function returnAjaxMsg($errno,$errtitle='',$data='') {
			 $returnArray = array('errno'=>$errno,
								'errtitle'=>$errtitle,
								'data'=>$data);
			 $this->ajaxReturn($returnArray);
	}
}