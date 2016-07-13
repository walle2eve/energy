<?php
class UserAction extends Action {
	public function _initialize() {
		//A('Index')->checkLogin();
		if($_SERVER['REQUEST_METHOD']!='POST'){
			$this->error('请求的页面不存在');
		}
    }
	public function login() {
		$login_name	 = I('username');
		$login_pwd	 = I('password');
		$User = D("User");
		$return = $User->login($login_name,$login_pwd);
		if($return['errno'])$this->error($return['errtitle']);

		switch($return['userinfo']['user_kind']){
			case '301010':
			case '301020':
			case '301030':
			case '301040':
				$this->loginSuccess($return['userinfo']);
				$this->success('登录成功',U('Main/index_main'));
				break;
			default:
				session_destroy();
				$this->error('权限不足，请重新登录');
				break;
		  }
	}
	private function loginSuccess($user_info) {
		//session('[destroy]');
		session('user_id',$user_info['user_id']);
		session('login_name',$user_info['login_name']);
		session('user_kind',$user_info['user_kind']);
		session('org_id',$user_info['org_id']);
	}
	public function editPass() {
		$return = D('User')->editPass();
		if(0!=$return['errno'])$this->error($return['errtitle']);
		$this->success('密码修改成功，请牢记新密码！');
	}
	///修改用户密码
	public function setUserPass(){
		$login_name = I('login_name');
	    $return = D('User')->resetPass($login_name);
	    if(0!=$return['errno'])$this->error($return['errtitle']);
   	    $this->success('用户密码重置成功！',U('Main/manager'));
	}
	///修改用户信息
	public function editUserInfo(){
		$userinfo['link_man'] = I('link_man','');
		$userinfo['link_phone'] = I('link_phone','');
		$userinfo['link_email'] = I('link_email','');
		
		$user_kind = session('user_kind');
		
		if($user_kind <> 301010){
			$userinfo['leader_man'] = I('leader_man','');
			$userinfo['leader_phone'] = I('leader_phone','');
			$userinfo['leader_email'] = I('leader_email','');
		}
		
	    $return = D('User')->editUserInfo($userinfo);
	    if(0!=$return['errno'])$this->error($return['errtitle']);
   	    $this->success('用户信息修改成功！！');
	}
}