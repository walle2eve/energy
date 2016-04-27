<?php
class SchoolModel extends Model{
	//根据区县ID和年度时间段获取已上报和未上报的学校情况
	public function getAddStatus($map = array()){
		$town_id = isset($map['town_id'])?$map['town_id']:0;
		$year = isset($map['year'])?$map['year']:0;
		$quarter = isset($map['quarter'])?$map['quarter']:0;
		$add_status = isset($map['add_status'])?$map['add_status']:'0';
		
		$having = '';
		
		if($add_status == 1){
			$having = ' having countid > 0';
		}elseif($add_status == -1){
			$having = ' having countid = 0';
		}
			
		$count = $this->query("SELECT COUNT(1) as num FROM (select count(i.school_id) as countid from energy_school s  left join  energy_info i on i.school_id = s.school_id and i.`year` = %d and i.`quarter` = %d left join energy_school_type dict on dict.type_id = s.school_type left join energy_town town on town.town_id = s.town_id where s.town_id = %d and s.is_del = 0 group by s.school_id " .$having. " order by s.orderby) TMP_TB",array($year,$quarter,$town_id));
		
		if(isset($count[0]['num'])) $count = $count[0]['num'];
		else $count = 0;
		
		import("ORG.Util.Page");
		$p = new Page ($count, C('PAGE_LISTROWS'));
		$page = $p->show();
		$limit  = $p->firstRow.','.$p->listRows;
		
		$list = $this->query("SELECT s.town_id,town.town_name,s.school_code,s.school_name,dict.type_name AS school_type_name,COUNT(i.school_id) AS countid,i.add_time,i.year,i.quarter,u.link_man,u.link_phone FROM energy_school s LEFT JOIN  energy_info i ON i.school_id = s.school_id AND i.`year` = %d AND i.`quarter` = %d  left Join energy_user u ON u.org_id = s.school_id LEFT JOIN energy_school_type dict ON dict.type_id = s.school_type LEFT JOIN  energy_town town ON town.town_id = s.town_id WHERE s.town_id = %d AND s.is_del = 0 GROUP BY s.school_id " .$having. " ORDER BY s.orderby LIMIT ".$limit,array($year,$quarter,$town_id));
		
		return array('page'=>$page,'list'=>$list);
	}
	/**
	* 2016年需求变化，现将所有涉及学校办学类型SCHOOL_TYPE字段的信息全部转移至energy_school_type表
	* 原energy_dict表 字典值201 弃用
	*/
  public function addHighSchool($data){
	  $is_school = false;
	  //校验学校编码是否已经存在
	  $is_school = $this->where("school_code = '%s'",$data['school_code'])->getField('school_code');
	  
	  if($is_school)return array('errno'=>201,'errtitle'=>'学校标识码已经存在！');
	  
	  $is_school = $this->where("school_name = '%s'",$data['school_name'])->getField('school_name');
	  
	  if($is_school)return array('errno'=>202,'errtitle'=>'学校名称已经存在！');
	  
	  $data['town_id'] = 110000;
	  $return  = $this->add($data);
	  
	  if($return){
		  return array('errno'=>0,'errtitle'=>'高校添加成功！');
	  }
	  return array('errno'=>3,'errtitle'=>'高校添加失败！');
  }
  //修改学校信息
  public function editSchool($data){
	  $is_school = false;
	  
	  //校验学校编码是否已经存在
	  
	  $school_id = $data['id'];
	  
	  unset($data['id']);
	  
	  $is_school = $this->where("school_name = '%s' AND school_id <> %d",$data['school_name'],$school_id)->getField('school_name');
	  
	  if($is_school)return array('errno'=>202,'errtitle'=>'学校名称已经存在！');
	  
	  $data['update_time'] = date('Y-m-d H:i:s');
	  
	  $return  = $this->where('school_id = %d',array($school_id))->save($data);
	  
	  if($return){
		  return array('errno'=>0,'errtitle'=>'学校信息修改成功！');
	  }
	  return array('errno'=>3,'errtitle'=>'学校信息修改失败！');
  }
  //shanchu学校信息
  public function delSchool($school_id){

	if(!$school_id)return array('errno'=>222,'errtitle'=>'参数不正确！');
		
	  $is_school = $this->where("school_id = %d",$school_id)->getField('school_name');
	  
	  if(!$is_school)return array('errno'=>232,'errtitle'=>'学校信息不存在！');
	  
	  $data['is_del']  = 1;
	  
	  $data['update_time'] = date('Y-m-d H:i:s');
	  
	  $return  = $this->where('school_id = %d',array($school_id))->save($data);
	  
	  if($return){
		  return array('errno'=>0,'errtitle'=>'删除学校成功');
	  }
	  return array('errno'=>3,'errtitle'=>'删除学校失败');
  }
   //学校列表
	public function getSchoolList($town_id=0,$school_type=0,$school_id =0,$ac="option"){
		// ac 控制是否分页 list 列表显示需要分页，option 下拉框显示无需分页
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
				$where = 'school_id = '.session('org_id');
				break;
			default:
				$where = '1=0';
				break;
		}
		if($school_type)$where .= ' AND school_type = '.$school_type;
		if($school_id)$where .= ' AND school_id = '.$school_id;
		
		$where .= ' AND s.is_del = 0';
		
		
		if($ac == 'list'){
			$count =  $this->alias('s')->join('LEFT JOIN energy_school_type ed ON ed.type_id = s.school_type')->where($where)->count();    //计算总数
			
			import("ORG.Util.Page");

			$p = new Page ($count, C('PAGE_LISTROWS'));
			
			$page = $p->show();
			
			$limit  = $p->firstRow.','.$p->listRows;
		}else{
			$limit = '';
		}
		
		$list = $this->alias('s')->join('LEFT JOIN energy_school_type ed ON ed.type_id = s.school_type')->field('s.*,ed.type_name AS school_type_name')->where($where)->order('orderby DESC')->limit($limit)->select();

		return array('page'=>$page,'list'=>$list);
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
		if(isset($schoolList['list']) && !empty($schoolList['list'])){
			foreach($schoolList['list'] as $v){
				$selected = '';
				if($school_id == $v['school_id']){
					$selected = 'selected=selected';
				}
				$selstr .= "<option value=\"{$v['school_id']}\" {$selected}>{$v['school_name']}</option>";
			}
		}
		return $selstr;
	}

	public function getSchoolOtherInfo($school_id){
		if(!$school_id) return false;
		$schoolInfo = $this->alias('s')->field('s.town_id,s.school_code,s.school_name,s.school_type,d.type_name as school_type_name')->join('energy_school_type d on d.type_id = s.school_type')->where('s.school_id = %d',array($school_id))->find();
		return $schoolInfo;
	}
	
	//获取学校xinxi
	public function getInfo($school_id){
		return $this->where('school_id = %d',array($school_id))->find();
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
		//根据当前类型ID 查找所有该类型下子类型
		
		if($school_type){
			//$school_types = D('SchoolType')->getTypesIdArr($school_type);
			
			$where .= ' AND s.school_type = '.$school_type;
		}
		if($school_id)$where .= ' AND s.school_id = '.$school_id;
		if($year)$where .= ' AND i.year = '.$year;
		if($quarter)$where .= ' AND i.quarter = '.$quarter;

		$where .= ' AND s.is_del = 0';
		
		//$count =  $this->alias('s')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_dict d ON d.dict_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->count();    //计算总数
		
		$count =  $this->alias('s')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_school_type d ON d.type_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->count();    //计算总数
		
		import("ORG.Util.Page");

		$p = new Page ($count, C('PAGE_LISTROWS'));
		
		$page = $p->show();

		//$list = $this->alias('s')->field('i.id,s.school_id,s.school_name,t.town_name,d.dict_name AS school_type_name,s.school_code,i.year,i.quarter,i.is_del')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_dict d ON d.dict_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->order('s.orderby,s.school_id ')->limit($p->firstRow.','.$p->listRows)->select();
		$list = $this->alias('s')->field('i.id,s.school_id,s.school_name,t.town_name,d.type_name AS school_type_name,s.school_code,i.year,i.quarter,i.is_del')->join('LEFT JOIN energy_town t ON t.town_id = s.town_id')->join('LEFT JOIN energy_school_type d ON d.type_id = s.school_type')->join('LEFT JOIN energy_info i ON i.school_id = s.school_id')->where($where)->order('s.orderby,s.school_id ')->limit($p->firstRow.','.$p->listRows)->select();
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