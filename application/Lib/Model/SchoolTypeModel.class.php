<?php
class SchoolTypeModel extends Model{
	// 学校类型（高校）下拉框
	public function getOptions($upid=0,$level=0,$optionstr='',$t='default'){
		//str_pad
		$data = $this->where('up_id = %d AND is_del = 0',$upid)->order('order_no,type_id ')->select();
		foreach($data as $row){
			$levelstr = str_pad('',$level,'-') . ' ';
			if($t == 'edit' && $row['up_id'] == 0) $disabled = "disabled=true";
			else $disabled = '';
			$optionstr .= "<option value=" . $row['type_id'] . " ".$disabled.">" . $levelstr.$row['type_name'] . "</option>";
			if($this->getSonCount($row['type_id'])){
				$level2 = $level + 1;
				$optionstr = $this->getOptions($row['type_id'],$level2,$optionstr);
			}
			//$optionstr .= $optionstr2;
		}
		return $optionstr;
	}
	public function getSonCount($typeid){
		return $this->where('up_id = %d AND is_del = 0',$typeid)->count();
	}
	// 添加类型
	public function addSchoolType($up_id,$type_name){
		$is_up_id = $this->where('type_id = %d AND is_del = 0',$up_id)->getField('type_id');
		if(!$is_up_id)return array('errno'=>1,'errtitle'=>'您选择的父类型不存在，请刷新后重新选择');
		
		$is_type_name = $this->where("type_name = '%s' AND is_del = 0",$type_name)->getField('type_name');
		if($is_type_name != '') return array('errno'=>2,'errtitle'=>'您要添加的类型名称['.$type_name.']已存在，不能重复添加');
		
		$data['up_id'] = $up_id;
		$data['type_name'] = $type_name;
		$data['update_time'] = date('Y-m-d H:i:s');
		$type_id = $this->add($data);

		if($type_id){
			return array('errno'=>0,'errtitle'=>'类型添加成功');
		}
		else return array('errno'=>22,'errtitle'=>'类型添加失败');
	}
	// 修改类型
	public function editSchoolType($type_id,$type_name,$up_id){
		
		$data = array();
		
		if(!$type_id)return array('errno'=>1,'errtitle'=>'请选择要修改的类型！');
		$typeinfo = $this->where('type_id = %d',$type_id)->find();
		
		if(!$typeinfo)return array('errno'=>2,'errtitle'=>'不存在的类型！');
		
		if($typeinfo['up_id'] == 0)return array('errno'=>3,'errtitle'=>'当前类型【'.$typeinfo['type_name'].'】不可操作！');
		
		if($up_id > 0){
			if($up_id == $typeinfo['type_id'])return array('errno'=>24,'errtitle'=>'您要修改的父类型与子类型一致，请重新选择');
			if($up_id == $typeinfo['up_id'])return array('errno'=>24,'errtitle'=>'您要修改的父类型与原父类型一致，无需修改');
			$is_up_id = $this->where('type_id = %d AND is_del = 0',$up_id)->getField('type_id');
			if(!$is_up_id)return array('errno'=>12,'errtitle'=>'您选择的父类型不存在，请刷新后重新选择');
			$data['up_id'] = $up_id;
		}
		
		if($type_name != ''){
			if($type_name == $typeinfo['type_name'])return array('errno'=>24,'errtitle'=>'您要修改的类型名称['.$type_name.']与原名称一致，无需修改');
			$is_type_name = $this->where("type_name = '%s' AND type_id <> %d AND is_del = 0",$type_name,$type_id)->getField('type_name');
			if($is_type_name != '') return array('errno'=>22,'errtitle'=>'您要修改的类型名称['.$type_name.']已存在，不能进行修改');
			
			$data['type_name'] = $type_name;
		}
		
		if(empty($data)){
			return array('errno'=>23,'errtitle'=>'您没有做任何修改！');
		}
		$data['update_time'] = date('Y-m-d H:i:s');
		
		$type_id = $this->where('type_id = %d',$type_id)->save($data);

		if($type_id){
			return array('errno'=>0,'errtitle'=>'类型修改成功！');
		}
		else return array('errno'=>22,'errtitle'=>'类型修改失败！');
	}
	// 删除类型
	public function delSchoolType($type_id){
		
		if(!$type_id)return array('errno'=>1,'errtitle'=>'请选择要修改的类型！');
		$typeinfo = $this->where('type_id = %d',$type_id)->find();
		
		if(!$typeinfo)return array('errno'=>2,'errtitle'=>'不存在的类型！');
		
		$typeSchoolCount = D('School')->where('school_type = %d',$type_id)->count();
		
		if($typeSchoolCount >０)return array('errno'=>23,'errtitle'=>'该类型下已有学校，不能进行删除操作!');
		
		$data['is_del'] = 1;
		$data['update_time'] = date('Y-m-d H:i:s');
		
		$type_id = $this->where('type_id = %d',$type_id)->save($data);

		if($type_id){
			return array('errno'=>0,'errtitle'=>'类型删除成功');
		}
		else return array('errno'=>22,'errtitle'=>'类型删除失败');
	}
	//加载类型ztree
	public function getTypesZtree($up_id=0){
		$info = $this->field('type_id AS id,type_name AS name,up_id AS pId')->where('is_del = 0')->select();
		foreach($info as &$row){
			if($row['pid'] == 0)$row['open'] = true;
		}
		return $info;
	}
	/**
	public function getTypesZtree($up_id = 0,$ar = array()){
		$data = $this->field('type_id AS id,type_name AS name,up_id AS pId')->where('up_id = %d AND is_del = 0',$up_id)->order('order_no,type_id ')->select();
		//echo M()->getlastsql();
		foreach($data as $row){
			if($row['pId'] == 0)$row['open'] = true;
			array_push($ar,$row);
			if($this->getSonCount($row['id'])){
				$ar = $this->getTypesZtree($row['id'],$ar);
			}
		}
		return $ar;
	}
	**/
}
?>