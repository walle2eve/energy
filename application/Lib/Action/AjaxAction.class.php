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
		$town_id = $_REQUEST['town_id'];
		$school_type = $this->_get('school_type');
		$schoolSelect = D('School')->getSchoolSelect($town_id,0,$school_type);
		if(!empty($schoolSelect))$this->returnAjaxMsg(0,'',$schoolSelect);
		else $this->returnAjaxMsg(1,'学校列表为空');
	}
	//学校类型，学校代码
	public function getSchoolOtherInfo(){
		$school_id = $_REQUEST['school_id'];
		$schoolInfo = D('School')->getSchoolOtherInfo($school_id);
		if(!empty($schoolInfo))$this->returnAjaxMsg(0,'',$schoolInfo);
		else $this->returnAjaxMsg(1,'学校错误');
	}
	private function returnAjaxMsg($errno,$errtitle='',$data='') {
			 $returnArray = array('errno'=>$errno,
								'errtitle'=>$errtitle,
								'data'=>$data);
			 $this->ajaxReturn($returnArray);
	}
}