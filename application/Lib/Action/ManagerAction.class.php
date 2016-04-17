<?php
class ManagerAction extends Action {
	public $referUrl = '';
	public function _initialize() {
		$this->referUrl = $_SERVER['HTTP_REFERER'];
		//检测用户是否登录
		A('Index')->checkLogin();
		$this->assign('login_name',session('login_name'));
		$user_kind = session('user_kind');
		$this->assign('user_kind',$user_kind);
	}

	public function addUser(){
		$user_kind = session('user_kind');
		//根据当前登录用户判断用户拥有的添加权限
		$kinds = D('Dict')->getUserKinds($user_kind);
		if(!$kinds)$this->showStatus('您没有权限执行本操作！');
		if(IS_POST){
			$login_name = I('login_name');
			$login_pwd = I('login_pwd');
			$user_kind = I('user_kind');
			$org_id = I('org_id');
			
			if(!$login_name || !$login_pwd || !$user_kind || !$org_id){
				return array('errno'=>1,'errtitle'=>'提交的数据错误，全部都不能为空！');
			}
			
			$return = D('User')->addUser($login_name,$login_pwd,$user_kind,$org_id);
			return $this->ajaxReturn($return);
		}
		$this->assign('user_kinds',$kinds);
		$this->display();
	}
	// 高校管理列表
	public function highSchool(){
		$user_kind = session('user_kind');
		if($user_kind != 301010)$this->showStatus('您没有权限执行本操作！');
		$townid = session('org_id');

		$school_type = I('school_type',0);
		$school_id = I('school_id',0);
		
		$highSchoolType = D('Dict')->getDictListByUpid(201,'AND left(dict_id,4)=2011');
		$this->assign('highSchoolType',$highSchoolType);

		$school_list = D('School')->getSchoolList($townid,$school_type,$school_id);
		$this->assign('school_list',$school_list);
		
		$this->assign('school_type',$school_type);
		$this->display(); 
	}
	//public 添加高校
	public function addHighSchool(){
		$highSchoolType = D('Dict')->getDictListByUpid(201,'AND left(dict_id,4)=2011');
		$this->assign('highSchoolType',$highSchoolType);
		
		if(IS_POST){
			$data = I('post.',array());
			
			$school_code = I('school_code');
			$school_name = I('school_name');
			$school_type = I('school_type');
			
			if(!$school_code){
				return array('errno'=>1,'errtitle'=>'请填写学校编码');
			}
			if(!$school_name){
				return array('errno'=>1,'errtitle'=>'请填写学校名称');
			}
			if(!$school_type){
				return array('errno'=>1,'errtitle'=>'请选择学校类型');
			}
			$return = D('School')->addHighSchool($data);
			return $this->ajaxReturn($return);
		}
		
		$this->display();
	}
	// 高等院校分类管理
	public function setHighSchoolType(){
		//添加修改删除时的下拉菜单选择项
		$school_type_options = D('SchoolType')->getOptions();
		$edit_school_type_options = D('SchoolType')->getOptions(0,0,'','edit');
		$this->assign('school_type_options',$school_type_options);
		$this->assign('edit_school_type_options',$edit_school_type_options);
		//
		$this->display();
	}
	private function showStatus($msg,$status = 'error',$referUrl = ''){
		if($referUrl == '')$referUrl = $this->referUrl;
		$this->$status($msg,$referUrl);
	}
}