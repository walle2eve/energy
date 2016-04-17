<?php
class DictModel extends Model{
	const KIND_ID = 301;
	const SHIJI_KIND = 301010;
	const QUXIAN_KIND = 301020;
	const XUEXIAO_KIND = 301040;
	//101
	public function getUnitList(){
		return $this->getDictListByUpid('101');
	}
	//
	public function getDictListByUpid($dict_upid = 0,$andWhere = ''){
		$getunitlist =  $this->where('status = 1 AND dict_upid = '.$dict_upid.' '.$andWhere)->order('dict_id')->select();
		foreach($getunitlist as $k=>$row){
			if($data = $this->getDictListByUpid($row['dict_id'])){
				$getunitlist[$k]['son'] = $data;
			}
		}
		return $getunitlist;
	}
	public function getDictName($dict_id){
		return $this->where('dict_id = '.$dict_id)->find();
	}
	public function getSchTypesByTownid($town_id){
		return $this->alias('dict')->field('dict.dict_id,dict.dict_name')->join('LEFT JOIN energy_school sch ON sch.school_type = dict.dict_id')->where('sch.town_id = %d AND sch.school_type <> 201300',array($town_id))->group('dict.dict_id')->order('dict.dict_id')->select();
	}
	
	//获取用户有权限管理的用户类别
	//2016-04-17
	//
	public function getUserKinds($user_kind){
		$where = 'dict_upid = ' . self::KIND_ID;
		switch($user_kind){
			case self::SHIJI_KIND:
				$where .= "";
				break;
			case self::QUXIAN_KIND;
				$where .= " AND dict_id IN (".self::QUXIAN_KIND.",".self::XUEXIAO_KIND.")";
				break;
			default:
				return false;
				break;
		}
		return $this->where($where)->select();
	}
}
?>