<?php
class SchoolModel extends Model{

	public function getSchoolList($town_id=0,$school_type=0){
		$user_kind = session('user_kind');
		$where = '';
		switch($user_kind){
			case '301010':
				$where = 'town_id = '.$town_id;
				break;
			case '301020':
				$where = 'town_id = '.session('org_id');
				break;
			case '301030':
			case '301040':
				$where = 'school_id = '.session('org_id');
				break;
			default:
				$where = '1=0';
				break;
		}
		if($school_type)$where .= ' AND school_type = '.$school_type;
		return $this->where($where)->order('orderby DESC')->select();
	}
	public function getSchoolListByids($andWhere){
		$where = ' 1=1';
		$where .= $andWhere;
		return $this->field('town_id,school_id,school_name')->where($where)->select();
	}
	public function getTownId($school_id){
		return $this->where('school_id = '.$school_id)->getField('town_id');
	}
	public function getSchoolSelect($town_id=0,$school_id=0,$school_type){
		$schoolList = $this->getSchoolList($town_id,$school_type);
		$selstr = '';
		foreach($schoolList as $v){
			$selected = '';
			if($school_id == $v['school_id']){
				$selected = 'selected=selected';
			}
			$selstr .= "<option value=\"{$v['school_id']}\" {$selected}>{$v['school_name']}</option>";
		}
		return $selstr;
	}

	public function getSchoolOtherInfo($school_id){
		if(!$school_id) return false;
		$schoolInfo = $this->alias('s')->field('s.town_id,s.school_code,s.school_name,s.school_type,d.dict_name as school_type_name')->join('energy_dict d on d.dict_id = s.school_type')->where('s.school_id = %d',array($school_id))->find();
		return $schoolInfo;
	}
	public function getSchoolAndInfoList($map = array()){

		$town_id = isset($map['town_id'])?$map['town_id']:0;
		$school_id = isset($map['school_id'])?$map['school_id']:0;
		$school_type = isset($map['school_type'])?$map['school_type']:0;
		$year = isset($map['year'])?$map['year']:0;
		$quarter = isset($map['quarter'])?$map['quarter']:0;

		//高校及市教委直属直管单位季度上报，其他半年度上报
		if($town_id == '110000' || $town_id == '110100' || substr($school_type,0,4) == '2011' || substr($school_type,0,4) == '2012'){
			$yeartype = 'jidu';
		}else{
			$yeartype = 'bannian';
		}

		$user_kind = session('user_kind');
		$where = '';
		switch($user_kind){
			case '301010':
				$where = 's.town_id = '.$town_id;
				break;
			case '301020':
				$where = 's.town_id = '.session('org_id');
				break;
			case '301030':
			case '301040':
				$where = 's.school_id = '.session('org_id');
				break;
			default:
				$where = '1=0';
				break;
		}
		if($school_type)$where .= ' AND s.school_type = '.$school_type;
		if($school_id)$where .= ' AND s.school_id = '.$school_id;
		if($year)$where .= ' AND i.year = '.$year;
		if($quarter)$where .= ' AND i.quarter = '.$quarter;

		$count =  $this->alias('s')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_dict d ON d.dict_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->count();    //计算总数
		
		import("ORG.Util.Page");

		$p = new Page ($count, C('PAGE_LISTROWS'));
		
		$page = $p->show();

		$list = $this->alias('s')->field('i.id,s.school_id,s.school_name,t.town_name,d.dict_name AS school_type_name,s.school_code,i.year,i.quarter,i.is_del')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_dict d ON d.dict_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->order('s.orderby,s.school_id ')->limit($p->firstRow.','.$p->listRows)->select();
		foreach($list as $k=>$row){
			if($row['id']){
				if($yeartype == 'jidu'){
					$list[$k]['yearStr'] = $row['year'].'年第'.$row['quarter'].'季度';
				}else{
					$list[$k]['yearStr'] = $row['year'].'年'.($row['quarter']==2?'下':'上').'半年';
				}
			}
		}

		return array('page'=>$page,'list'=>$list);
	}
}
?>