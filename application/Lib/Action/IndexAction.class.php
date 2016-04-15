<?php
class IndexAction extends Action {
	public function _empty() {
		 $this->index();
	}
    public function index() {
		 $this->checkLogin();
		 $this->reurl();
    }
	public function checkLogin() {
	   $user_id = session('user_id');
	   $user_kind = session('user_kind');
        if(empty($user_id)  || empty($user_kind)) {
			$this->assign('headTitle','登录系统');
			$this->display('Index:login');
			exit();
        }
	}
	public function editPass() {
		$this->checkLogin();
		$this->assign('headTitle','修改密码');

		$this->assign('login_name',session('login_name'));
		$this->display();
	}
	public function editUserInfo(){
		$this->checkLogin();
		$this->assign('headTitle','个人信息设置');

		$info = D('User')->getUserInfoAll(session('user_id'));
		$this->assign('info',$info);
		$this->display();
	}
	public function logout(){
		session('[destroy]');
		$this->success('已退出系统',U('Index'));
	}
	
	private function reurl() {
		A('Main')->index_main();
	}
	
}