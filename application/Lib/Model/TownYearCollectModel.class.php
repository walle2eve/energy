<?php
class TownYearCollectModel extends Model{
	public function getInfoByYear($town_id,$year){
		return $this->where(array('town_id'=>$town_id,'year'=>$year))->getField('id');
	}
	//修改数据
	public function editInfo($data){
		$id = isset($data['id'])?$data['id']:0;
		$add_time = $data['add_time'];
		$info = $this->getInfoById($id);
		if(empty($info)){
			return array('errno'=>1,'errtitle'=>'信息不存在或已被删除');
		}
		if((session('user_kind') == '301020' && $info['town_id'] != session('org_id'))){
			return array('errno'=>2,'errtitle'=>'您没有权限操作该条数据');
		}
		unset($data['id']);
		
		$data['input_time'] = date('Y-m-d H:i:s');
		if($this->where('id = '.$id)->save($data)){
			return array('errno'=>'0','errtitle'=>'数据修改成功');
		}else{
			return array('errno'=>'2','errtitle'=>'修改失败，请重试');
		}
	}
	//删除数据
	public function delInfo($id){
		$info = $this->getInfoById($id);
		if(empty($info)){
			return array('errno'=>1,'errtitle'=>'信息不存在或已被删除');
		}
		if((session('user_kind') == '301020' && $info['town_id'] != session('org_id'))){
			return array('errno'=>2,'errtitle'=>'您没有权限操作该条数据');
		}
		if($this->where('id = '.$id)->delete()){
			return array('errno'=>'0','errtitle'=>'删除成功');
		}else{
			return array('errno'=>'2','errtitle'=>'删除失败，请重试');
		}
	}
	public function getInfoById($id){
		$info = $this->alias('i')->field('i.*,t.town_name')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->where('i.is_del = 0 AND id = '.$id)->find();
		if(!empty($info)){
			$info['yearStr'] = $info['year'].'年';
		}
		return $info;
	}
	//获取区县年度汇总数据列表
	public function getTownCollectList($map = array()){
		$town_id = isset($map['town_id'])?$map['town_id']:0;
		$user_kind = session('user_kind');

		switch($user_kind){
			case '301010':
				$town_id = $town_id>100000?$town_id:0;
				break;
			case '301020':
				$town_id = session('org_id');
				break;
			default:
				break;
		}

		$where = ' i.is_del = 0 ';
		$where .= $town_id ? ' AND i.town_id = ' . $town_id : '';
		$where .= $map['year'] ? ' AND i.year = ' . $map['year'] : '';

		$count = $this->alias('i')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->where($where)->count();    //计算总数
		import("ORG.Util.Page");
		$p = new Page ($count, C('PAGE_LISTROWS'));

		$list = $this->alias('i')->field('i.id,i.town_id,t.town_name,i.year')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->where($where)->order('t.town_id,year')->limit($p->firstRow.','.$p->listRows)->select();
		
		//echo M()->getlastsql();
		
		$page = $p->show();

		foreach($list as $k=>$row){
			$list[$k]['yearStr'] = $row['year'].'年';
		}

		return array('page'=>$page,'list'=>$list);
	}
	public function addInfo($data){

		$infoId = $this->getInfoByYear($data['town_id'],$data['year']);
		if($infoId){
			$yearStr = $year.'年';
			return array('errno'=>1,'errtitle'=>'本区县'.$yearStr.'汇总数据已上报');
		}
		//综合能耗，单位 吨标准煤
		$data['info_101098'] = 0;
		//各单位能耗折标系数表
		$stdList = D('Std')->getStdList();
		
		//根据折标系数计算各能耗标准煤并汇总
		foreach($stdList as $k=>$row){
			//综合能耗
			$data['info_101098'] = $data['info_101098'] + ($row['zbzmxs'] * $row['coef'] * $data['info_'.$row['std_id']]);
			//综合费用
			$data['info_101099'] = $data['info_101099'] + $data['info_'.($row['std_id']+1)];
		}
		//总能耗，单位 吨标准煤
		$data['info_101098'] = $data['info_101098'] + ($data['info_101040'] * 10000);
		//总费用，单位 万元
		$data['info_101099'] = $data['info_101099'] + $data['info_101041'];


		$data['input_time'] = date('Y-m-d H:i:s');
		

		if($this->add($data)){
			return array('errno'=>'0','errtitle'=>'数据上报成功');
		}else{
			return array('errno'=>'2','errtitle'=>'上报失败，请重试');
		}
	}
	//数据汇总
	//town_id		区县代码
	//year			年度

	public function getInfoCollect($town_id,$year,$school_type=0){
		if($town_id > 99) {
			$infoid = $this->where('town_id = %d AND year = %d AND is_del = 0',array($town_id,$year))->getField('id');
			if(!empty($infoid))
			return $this->getInfoById($infoid);
			else return null;
		}
		/***/
		$whereStr = 'i.is_del = 0 AND i.year = %d ';
		$whereArr = array($year);
		$groupStr = 'i.year';

		
		/***/
		$info = $this->alias('i')->field('
			ROUND(SUM(i.info_101001),4) AS info_101001,
			SUM(i.info_101002) AS info_101002,
			SUM(i.info_101003) AS info_101003,
			SUM(i.info_101004) AS info_101004,
			SUM(i.info_101005) AS info_101005,
			SUM(i.info_101006) AS info_101006,
			SUM(i.info_101007) AS info_101007,
			SUM(i.info_101008) AS info_101008,
			SUM(i.info_101009) AS info_101009,
		
		  ROUND(SUM(i.info_101010),4) AS info_101010,
		  ROUND(SUM(i.info_101011),4) AS info_101011,
		  ROUND(SUM(i.info_101012),4) AS info_101012,
		  ROUND(SUM(i.info_101013),4) AS info_101013,
		  ROUND(SUM(i.info_101014),4) AS info_101014,
		  ROUND(SUM(i.info_101015),4) AS info_101015,
		  ROUND(SUM(i.info_101016),4) AS info_101016,
		  ROUND(SUM(i.info_101017),4) AS info_101017,
		  ROUND(SUM(i.info_101018),4) AS info_101018,
		  ROUND(SUM(i.info_101019),4) AS info_101019,
		  ROUND(SUM(i.info_101020),4) AS info_101020,
		  ROUND(SUM(i.info_101021),4) AS info_101021,
		  ROUND(SUM(i.info_101022),4) AS info_101022,
		  ROUND(SUM(i.info_101023),4) AS info_101023,
		  ROUND(SUM(i.info_101024),4) AS info_101024,
		  ROUND(SUM(i.info_101025),4) AS info_101025,
		  ROUND(SUM(i.info_101026),4) AS info_101026,
		  ROUND(SUM(i.info_101027),4) AS info_101027,
		  ROUND(SUM(i.info_101028),4) AS info_101028,
		  ROUND(SUM(i.info_101029),4) AS info_101029,
		  ROUND(SUM(i.info_101030),4) AS info_101030,
		  ROUND(SUM(i.info_101031),4) AS info_101031,
		  ROUND(SUM(i.info_101032),4) AS info_101032,
		  ROUND(SUM(i.info_101033),4) AS info_101033,
		  ROUND(SUM(i.info_101034),4) AS info_101034,
		  ROUND(SUM(i.info_101035),4) AS info_101035,
		  ROUND(SUM(i.info_101036),4) AS info_101036,
		  ROUND(SUM(i.info_101037),4) AS info_101037,
		  ROUND(SUM(i.info_101038),4) AS info_101038,
		  ROUND(SUM(i.info_101039),4) AS info_101039,
		  ROUND(SUM(i.info_101040),4) AS info_101040,
		  ROUND(SUM(i.info_101041),4) AS info_101041,
		  ROUND(SUM(i.info_101042),4) AS info_101042,
		  ROUND(SUM(i.info_101043),4) AS info_101043,
		  ROUND(SUM(i.info_101044),4) AS info_101044,
		  ROUND(SUM(i.info_101045),4) AS info_101045,
		  ROUND(SUM(i.info_101046),4) AS info_101046,
		  ROUND(SUM(i.info_101047),4) AS info_101047,
		  ROUND(SUM(i.info_101098),4) AS info_101098,
		  ROUND(SUM(i.info_101099),4) AS info_101099,
		  i.year')->where($whereStr,$whereArr)->group($groupStr)->find();
  	
		return $info;
	}
}
?>