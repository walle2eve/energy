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
	//设置单价标准
	public function setStd(){
		$user_kind = session('user_kind');
		if($user_kind != 301010)$this->showStatus('您没有权限执行本操作！');
		$stds = M('std')->select();
		$this->assign('stdlists',$stds);
		if(IS_POST && IS_AJAX){
			$std_id = I('st',0);
			$data['min_price'] = I('min_price',0);
			$data['max_price'] = I('max_price',0);
			$data['input_time'] = date('Y-m-d H:i:s');
			if(!$std_id){
				$this->ajaxReturn(array('errno'=>1,'errtitle'=>'参数错误，请刷新后重试'));
			}
			if($data['min_price'] > $data['max_price']){
				$this->ajaxReturn(array('errno'=>2,'errtitle'=>'设置的单价区间最小值不能大于最大值！'));
			}
			$return = M('std')->where('std_id = %d',$std_id)->save($data);
			if($return){
				$this->ajaxReturn(array('errno'=>0,'errtitle'=>'设置成功！'));
			}else{
				$this->ajaxReturn(array('errno'=>9,'errtitle'=>'设置失败请重试！'));
			}
		}
		$this->display('stdList');
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
		
		$highSchoolTypeOptions = D('SchoolType')->getOptions(0,0,'','list',110000,$school_type);
		$this->assign('highSchoolTypeOptions',$highSchoolTypeOptions);

		$school = D('School')->getSchoolList($townid,$school_type,$school_id,'list');

		$this->assign('list',$school['list']);
		$this->assign('page',$school['page']);
		
		$this->assign('school_type',$school_type);
		$this->display(); 
	}
	//public 添加高校
	public function addHighSchool(){
		//$highSchoolType = D('Dict')->getDictListByUpid(201,'AND left(dict_id,4)=2011');
		//$this->assign('highSchoolType',$highSchoolType);
		
		$highSchoolTypeOptions = D('SchoolType')->getOptions(0,0,'','list');
		$this->assign('highSchoolTypeOptions',$highSchoolTypeOptions);
		
		if(IS_POST){
			$data = I('post.',array());
			
			$school_code = I('school_code');
			$school_name = I('school_name');
			$school_type = I('school_type');
			
			if(!$school_code){
				return array('errno'=>1,'errtitle'=>'请填写学校标识');
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
	//public 添加高校
	public function editSchool(){
		
		$school_id = I('id','');
		
		if(!$school_id)$this->error('学校参数错误！');
		
		$info = D('School')->getInfo($school_id);
		if(!$info)$this->error('没有找到该校的信息！');
		$this->assign('info',$info);
		
		if(IS_POST){
			$data = I('post.',array());
			
			$school_name = I('school_name');
			$school_type = I('school_type');
			
			if(!$school_name){
				return array('errno'=>1,'errtitle'=>'请填写学校名称');
			}
			if(!$school_type){
				return array('errno'=>1,'errtitle'=>'请选择学校类型');
			}
			$return = D('School')->editSchool($data);
			return $this->ajaxReturn($return);
		}
		

		
		$highSchoolTypeOptions = D('SchoolType')->getOptions(0,0,'','list',$info['town_id'],$info['school_type']);
		$this->assign('highSchoolTypeOptions',$highSchoolTypeOptions);
		
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
	//根据登录用户类型和时间段查看已填报和未填报的学校
	//
	public function showAddStatus(){
		$user_kind = session('user_kind');
		if($user_kind != 301010 && $user_kind != 301020)$this->showStatus('您没有权限执行本操作！');
		//区县下拉菜单
		$town_id = I('town_id','');
		if($user_kind == 301020)$town_id = session('org_id');
		$townSelect = D('Town')->getTownSelect($town_id);
		$this->assign('townSelect',$townSelect);
		
		$year = '';
		$$quarter = '';
		
		$year_quarter = I('year_quarter','');
		if($year_quarter != '')list($year,$quarter) = explode('_',$year_quarter);
		
		$map['town_id'] = $town_id;
		$map['year'] = $year;
		$map['quarter'] = $quarter;
		$map['add_status'] = I('add_status','all');
		// 时间段下拉菜单
		$yearSelect = D('Info')->getYears($map);
		$this->assign('yearSelect',$yearSelect);
		$this->assign('add_status',$map['add_status']);
		$this->assign('year',$year);
		$this->assign('quarter',$quarter);
		// 添加
		$info = D('School')->getAddStatus($map);
		
		$this->assign('page',$info['page']);
		$this->assign('list',$info['list']);
		
		$this->assign('user_kind',$user_kind);
		
		$this->display();
	}
	private function showStatus($msg,$status = 'error',$referUrl = ''){
		if($referUrl == '')$referUrl = $this->referUrl;
		$this->$status($msg,$referUrl);
	}
}