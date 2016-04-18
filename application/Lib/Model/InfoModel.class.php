<?php
class InfoModel extends Model{
	public function addInfo($data){
		$add_time = $data['add_time'];
		
		$year = date('Y',strtotime($add_time));
		
		//半年度
		$quarter = $this->getQuarter(date('n',strtotime($add_time)),$data['school_type']);

		//检测该学校该学年该季度是否上报过数据
		$infoId = $this->getInfoByYear($data['school_id'],$year,$quarter);
		if($infoId){
			if(substr($infoId['school_type'],0,4) == '2011' || substr($infoId['school_type'],0,4) == '2012'){
				$yearStr = $year.'年第'.$quarter.'季度';
			}else{
				$yearStr = $year.'年'.($quarter==2?'下':'上').'半年';
			}
			//return array('errno'=>1,'errtitle'=>'该校'.$year.'年第'.$quarter.'季度数据已上报');
			return array('errno'=>1,'errtitle'=>'该校'.$yearStr.'数据已上报');
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


		$data['year'] = $year;
		$data['quarter'] = $quarter;
		$data['input_time'] = date('Y-m-d H:i:s');
		
		$branch_schools = explode("\r\n",$data['branch_schools']);
		$tmp_branch = array();
		if(!empty($branch_schools)){
			foreach($branch_schools as  $val){
				if(trim($val) != ''){
					$tmp_branch[] = str_replace(',','，',$val);
				}			
			}
		}
		$data['branch_schools'] = '';
		if($tmp_branch != ''){
			$data['branch_schools'] = implode(',',$tmp_branch);
		}
		//备注：因故未能上报数据的学校填写备注
		$data['notes'] = trim($data['notes']);
		//标记是否有数据
		//2015-02-05
		if($data['notes'] != '')$data['hava_info'] = 0;

		if($this->add($data)){
			return array('errno'=>'0','errtitle'=>'数据上报成功');
		}else{
			return array('errno'=>'2','errtitle'=>'上报失败，请重试');
		}
	}
	
	public function getInfoByYear($school_id,$year=0,$quarter=0){
		$data = array('school_id'=>$school_id);
		if($year)$data['year'] = $year;
		if($quarter)$data['quarter'] = $quarter;
		$data['is_del'] = 0;
		return $this->where($data)->find();
	}
	//根据学校id获取
	public function getInfoById($id){
		$info = M('info i')->field('i.*,s.school_name,t.town_name,d.type_name AS school_type_name')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->join('LEFT JOIN energy_school s ON s.school_id = i.school_id')->join('LEFT JOIN energy_school_type d ON d.type_id = i.school_type')->where('i.is_del = 0 AND id = '.$id)->find();
		if(!empty($info)){
			//市属高校及市教委直属直管单位按照季度上报，其余按照半年度上报
			$quarterStr = $info['town_id'] == '110000' || $info['town_id'] == '110100' ? $info['quarter'] . '季度' : (($info['quarter']==2?'下':'上').'半年');
			$info['yearStr'] = $info['year'].'年'.$quarterStr;
			$info['branch_schools'] = str_replace(',',"\r\n",$info['branch_schools']);
		}
		return $info;
	}
	public function editInfo($data){
		$id = isset($data['id'])?$data['id']:0;
		$add_time = $data['add_time'];
		$info = $this->getInfoById($id);
		if(empty($info)){
			return array('errno'=>1,'errtitle'=>'信息不存在或已被删除');
		}
		if((session('user_kind') == '301020' && $info['town_id'] != session('org_id')) || (in_array(session('user_kind'),array('301030','301040')) && $info['school_id'] != session('org_id'))){
			return array('errno'=>2,'errtitle'=>'您没有权限操作该条数据');
		}
		unset($data['id']);
		
		$year = date('Y',strtotime($add_time));
		$quarter = $this->getQuarter(date('n',strtotime($add_time)),$info['school_type']);
		
		$data['year'] = $year;
		$data['quarter'] = $quarter;
		$data['input_time'] = date('Y-m-d H:i:s');
		if($this->where('id = '.$id)->save($data)){
			return array('errno'=>'0','errtitle'=>'数据修改成功');
		}else{
			return array('errno'=>'2','errtitle'=>'修改失败，请重试');
		}
	}
	public function delInfo($id){
		$info = $this->getInfoById($id);
		if(empty($info)){
			return array('errno'=>1,'errtitle'=>'信息不存在或已被删除');
		}
		if((session('user_kind') == '301020' && $info['town_id'] != session('org_id')) || (in_array(session('user_kind'),array('301030','301040')) && $info['school_id'] != session('org_id'))){
			return array('errno'=>2,'errtitle'=>'您没有权限操作该条数据');
		}
		//$data['is_del'] = 1;
		//$data['input_time'] = date('Y-m-d H:i:s');
		//if($this->where('id = '.$id)->save($data)){
		if($this->where('id = '.$id)->delete()){
			return array('errno'=>'0','errtitle'=>'删除成功');
		}else{
			return array('errno'=>'2','errtitle'=>'删除失败，请重试');
		}
	}
	//对比
	//$ct 对比方式 单位，时间
	//$unit 对比单位
	//$time 对比时间
	//$infounit 对比选项
	public function contrast($infounit,$town=0){
		$ct = cookie('ct');
		$unit = cookie('unit');//quxian
		$time = cookie('time');
		//$town = cookie('town');
		
		$return = array();

		$field = ' town_id,school_id,year,quarter,';

		if($ct == 'unit'){
			
			if($town > 0){//学校
				$whereSql = 'school_id IN ('.implode(',',$unit).')';
				//单位
				$schools = D('School')->getSchoolListByids(' AND '.$whereSql);
				foreach($schools as $v){
					$return['unit'] .= $v['school_name'].'、';
				}
			}else{//区县
				$whereSql = 'town_id IN ('.implode(',',$unit).')';
				//单位
				$towns = D('Town')->getTownList(' AND '.$whereSql);
				foreach($towns as $v){
					$return['unit'] .= $v['town_name'].'、';
				}
			}
			
			list($year,$quarter) = explode('_',$time);
			//时间
			$return['time'] = $year.'年'.($quarter==2?'下':'上').'半年';

			if($town > 0){//学校
				//半年度和季度
				$quarterStr = ($schools[0]['town_id'] == '110000' || $schools[0]['town_id'] == '110100') ? $quarter . '季度' : (($quarter==2?'下':'上').'半年');
				$return['time'] = $year.'年'.$quarterStr;
				
				$groupby = 'school_id';
			}else{
				$groupby = 'town_id';
			}
			$whereSql .= ' AND year = '.$year.' AND quarter = '.$quarter.'';

		}else{

			if($town > 0){//学校
				$whereSql = ' school_id = '.$unit;
				//单位
				$schools = D('School')->getSchoolListByids(' AND ' . $whereSql);
				$return['unit'] = $schools[0]['school_name'];

			}else{
				$whereSql = ' town_id = '.$unit;
				//单位
				$town = D('Town')->getTownList(' AND ' . $whereSql);
				$return['unit'] = $town[0]['town_name'];
			}

			foreach($time as $k=>$v){
				list($year,$quarter) = explode('_',$v);
				
				//时间
				if($town > 0 && ($schools[0]['town_id'] == '110000' || $schools[0]['town_id'] == '110100')){
					$quarterStr =  $quarter . '季度、';
					$return['time'] .= $year.'年'.$quarterStr;
				}else{
					$return['time'] .= $year.'年'.($quarter==2?'下':'上').'半年、';
				}
				
				if($k==0){
					$sql = ' (year = '.$year.' AND quarter = '.$quarter.') ';
				}else{
					$sql .= ' OR (year = '.$year.' AND quarter = '.$quarter.') ';
				}
			}
			$groupby = 'year,quarter';
			$whereSql .= ' AND ('.$sql.')';
		}


		//生均数和面均数如果为0,取1
		//学生数量info_101003 教师数量 info_101002
		//面积info_101001

		$infounitname = D('Dict')->getDictName($infounit);
		$fieldstr = 'SUM(info_'.$infounit.')';

		$fields = $field.'ROUND('.$fieldstr.',4) AS `total`,ROUND(ROUND('.$fieldstr.',4)/IF((SUM(info_101003)+SUM(info_101002))>0,(SUM(info_101003)+SUM(info_101002)),1),4) AS `avgs`,ROUND(ROUND('.$fieldstr.',4)/IF(SUM(info_101001)>0,SUM(info_101001),1),4) AS `avgm`';

		$return['infounit'] = !empty($infounitname['unit'])?($infounitname['dict_name'].'（'.$infounitname['unit'].'）'):$infounitname['dict_name'];
		$return['data'] = $this->field($fields)->where($whereSql)->group($groupby)->select();
		foreach($return['data'] as $k=>$row){
			//市属高校和市教委直属直管单位按照季度上报，其余按照半年度上报
			$quarterStr = $row['town_id'] == '110000' || $row['town_id'] == '110100' ? $row['quarter'] . '季度' : (($row['quarter']==2?'下':'上').'半年');

			$return['data'][$k]['yearStr'] = $row['year'].'年'.$quarterStr;
		}

		
		if($ct == 'unit'){
			if($town > 0){//学校
				foreach($return['data'] as $k=>$v){
					$town = D('School')->getSchoolListByids(' AND school_id = '.$v['school_id']);
					$return['data'][$k]['town'] = $town[0]['school_name'];
				}

			}else{
				foreach($return['data'] as $k=>$v){
					$towninfo = D('Town')->getTownList(' AND town_id = '.$v['town_id']);
					$return['data'][$k]['town'] = $towninfo[0]['town_name'];
				}
			}
		}

		return $return;
	}

	//数据汇总
	//town_id		区县代码
	//year			年度
	//schoolType	单位类别
	public function getInfoCollect($town_id,$year,$school_type=0){
		/***/
		$whereStr = 'i.is_del = 0 AND i.town_id = %d AND i.school_type <> 201300';
		$whereArr = array($town_id);
		$groupStr = 'i.town_id';
		if($school_type != 0){
			$whereStr  .= ' AND i.school_type = %d ';
			array_push($whereArr,$school_type);
			$groupStr  .= ',i.school_type';
		}
		$whereStr  .= ' AND i.year = %d ';
		array_push($whereArr,$year);
		$groupStr  .= ',i.year';
		/***/
		$info = $this->alias('i')->field('
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
		  i.year,
		  t.town_name,
  d.dict_name AS school_type_name ')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->join('LEFT JOIN energy_dict d ON d.dict_id = i.school_type')->where($whereStr,$whereArr)->group($groupStr)->find();
  	
		if(!empty($info)){
			$info['yearStr'] = $info['year'].'年';
			//获取各上报单位当前年度最后一次上报的数据，
			//根据school_id,year,quarter定位
			//2014-09-09
			$lastQuarterInfos = $this->alias('i')->field('school_id,year,MAX(quarter) AS quarter')
								->where($whereStr,$whereArr)
								->group('school_id')
								->select();
			
			$otherInfo = array('info_101001'=>0,
								'info_101002'=>0,
								'info_101003'=>0,
								'info_101004'=>0,
								'info_101005'=>0,
								'info_101006'=>0,
								'info_101007'=>0,
								'info_101008'=>0,
								'info_101009'=>0);
			//将取得的单位数据逐一相加
			foreach($lastQuarterInfos as $key=>$row){
				$ifn = $this->field('id,info_101001,info_101002,info_101003,info_101004,info_101005,
				  info_101006,info_101007,info_101008,info_101009')
				  ->where('is_del = 0 AND school_id = %d AND year = %d AND quarter = %d',
				  array($row['school_id'],$row['year'],$row['quarter']))
				  ->find();
				 // print_r($ifn);
				 // echo "<br />";
				  //echo M()->getlastsql();exit();
				  foreach($otherInfo as $k=>$v){
					$otherInfo[$k] = $v + $ifn[$k];
				  }
			}
			/**
				
		  //echo M()->getlastsql();
		  **/
			if($school_type == 0 || $school_type == '')$info['school_type_name'] = '全部';
			$info = array_merge($info,$otherInfo);
		}
		return $info;
	}
	//高校季度上报，其他半年度上报
	public function getQuarter($month,$school_type){
		if(substr($school_type,0,4) == '2011' || substr($school_type,0,4) == '2012'){//高校，市教委直属直管单位按照季度上报
			return $month%3==0?floor($month/3):ceil($month/3);
		}else{
			return $month<=6?1:2;
		}
	}
	public function getYear($year=0){
		$list = $this->field("year")->where("is_del=0")->group('year')->select();
		foreach($list as $k=>$row){
			$selectstr .= "<option value='".$row['year']."' ".($row['year']==$year?'selected':'').">";
			$selectstr .= $row['year']."年";
			$selectstr .= "</option>";
		}
		return $selectstr;
	}
	//获取时间下拉菜单那
	public function getYears($map){
		$town_id = isset($map['town_id'])?$map['town_id']:0;
		$school_id = isset($map['school_id'])?$map['school_id']:0;
		$school_type = isset($map['school_type'])?$map['school_type']:0;
		$year = isset($map['year'])?$map['year']:0;
		$quarter = isset($map['quarter'])?$map['quarter']:0;

		//高校、市教委指数直管单位季度上报，其他半年度上报
		if($town_id == '110000' || $town_id == '110100' || substr($school_type,0,4) == '2011' || substr($school_type,0,4) == '2012'){
			$yeartype = 'jidu';
		}else{
			$yeartype = 'bannian';
		}

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
		if($school_id)$where .= ' AND school_id = '.$school_id;
		//if($year)$where .= ' AND year = '.$year;
		//if($quarter)$where .= ' AND quarter = '.$quarter;

		$list = $this->field("year,quarter")->where($where)->group('year,quarter')->select();
		foreach($list as $k=>$row){
			$selectstr .= "<option value='".$row['year']."_".$row['quarter']."' ".($row['year']==$year&&$row['quarter']==$quarter?'selected':'').">";
			$selectstr .= $yeartype=='jidu'?$row['year']."年第".$row['quarter']."季度":$row['year']."年".(($row['quarter']==2)?'下':'上')."半年";
			$selectstr .= "</option>";
		}
		return $selectstr;
	}
	public function getYearQuarters($town_id){
		$where = 'is_del = 0';
		if($town_id == '110000'){
			$where .= ' AND town_id = 110000';
		}
		$list =  $this->field('year,quarter')->where($where)->group('year,quarter')->order('year,quarter')->select();
		foreach($list as $k=>$row){
		//高校及市教委直属直管单位按照季度上报，其余按照半年度上报
			if($town_id == '110000' || $town_id == '110100'){
				$list[$k]['yearStr'] = $row['year'].'年第'.$row['quarter'].'季度';
			}else{
				$list[$k]['yearStr'] = $row['year'].'年'.($row['quarter']==2?'下':'上').'半年';
			}
		}
		return $list;
	}
	//列表
	public function getInfoList($map = array()){

		$town_id = isset($map['town_id'])?$map['town_id']:0;
		$school_id = isset($map['school_id'])?$map['school_id']:0;
		$school_type = isset($map['school_type'])?$map['school_type']:0;

		$user_kind = session('user_kind');

		switch($user_kind){
			case '301010':
				$town_id = $town_id>100000?$town_id:0;
				break;
			case '301020':
				$town_id = session('org_id');
				break;
			case '301030':
			case '301040':
				$school_id = session('org_id');
				break;
		}

		$where = ' i.is_del = 0 ';
		$where .= $town_id?' AND i.town_id = '.$town_id:'';
		$where .= $school_id?' AND i.school_id = '.$school_id:'';
		$where .= $school_type?' AND i.school_type = '.$school_type:'';

		$count = M('info i')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->join('LEFT JOIN energy_school s ON s.school_id = i.school_id')->where($where)->count();    //计算总数
		import("ORG.Util.Page");
		$p = new Page ($count, C('PAGE_LISTROWS'));

		$list = M('info i')->field('i.id,i.town_id,s.school_name,t.town_name,d.dict_name AS school_type_name,i.school_code,i.year,i.quarter')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->join('LEFT JOIN energy_school s ON s.school_id = i.school_id')->join('LEFT JOIN energy_dict d ON d.dict_id = i.school_type')->where($where)->order('year DESC,quarter DESC')->limit($p->firstRow.','.$p->listRows)->select();
		$page = $p->show();

		foreach($list as $k=>$row){
			//市属高校和市教委直属直管单位按照季度上报，其余按照半年度上报
			$quarterStr = ($row['town_id'] == '110000' || $row['town_id'] == '110100') ? $row['quarter'] . '季度' : (($row['quarter']==2?'下':'上').'半年');

			$list[$k]['yearStr'] = $row['year'].'年'.$quarterStr;
		}

		return array('page'=>$page,'list'=>$list);
	}
	//查看各单位上传情况
	public function getShowAddStatus($town_id = 0){
		$user_kind = session('user_kind');
		switch($user_kind){
			case '301010':
				$where = ' 1=1 ';
				$group = 'i.town_id';
				break;
			case '301020':
				$where = 'i.town_id = ' . session('org_id');
				$group = 'i.school_type';
				break;
			case '301030':
			case '301040':
				$where = 'i.school_id = '.session('org_id');
				$group = 'i.school_id';
		}
		if($town_id > 0){
			$where = 'i.town_id = '.$town_id;
			//$group = 'i.school_type';
		}
		$where .= ' AND is_del = 0';
		$list = M('info i')->field('i.id,i.town_id,i.school_id,i.school_type,s.school_name,t.town_name,d.dict_name AS school_type_name,i.school_code,i.year,i.quarter,COUNT(i.id) AS `total`')->join('LEFT JOIN energy_town t ON t.town_id = i.town_id')->join('LEFT JOIN energy_school s ON s.school_id = i.school_id')->join('LEFT JOIN energy_dict d ON d.dict_id = i.school_type')->where($where)->group($group)->select();

		return $list;
	}

	//排序
	//$ct 排序方式 单位，时间
	//$unit 排序单位
	//$time 排序时间
	//$infounit 排序选项
	public function orderby($infounit,$town = 0){
		$ct = cookie('ct');
		$unit = cookie('unit');//quxian
		$time = cookie('time');
		
		$return = array();

		$field = ' town_id,school_id,year,quarter,';

		if($ct == 'unit'){
			if($town > 0){//学校
				$whereSql = 'school_id IN ('.implode(',',$unit).')';
				//单位
				$schools = D('School')->getSchoolListByids(' AND '.$whereSql);
				foreach($schools as $v){
					$return['unit'] .= $v['school_name'].'、';
				}
			}else{//区县
				$whereSql = 'town_id IN ('.implode(',',$unit).')';
				//单位
				$towns = D('Town')->getTownList(' AND '.$whereSql);
				foreach($towns as $v){
					$return['unit'] .= $v['town_name'].'、';
				}
			}

			list($year,$quarter) = explode('_',$time);
			//时间
			$return['time'] = $year.'年'.($quarter==2?'下':'上').'半年';

			if($town > 0){//学校
				//半年度和季度
				$quarterStr = ($schools[0]['town_id'] == '110000' || $schools[0]['town_id'] == '110100') ? $quarter . '季度' : (($quarter==2?'下':'上').'半年');
				$return['time'] = $year.'年'.$quarterStr;
				
				$groupby = 'school_id';
			}else{
				$groupby = 'town_id';
			}
			$whereSql .= ' AND year = '.$year.' AND quarter = '.$quarter.'';

		}else{
			if($town > 0){//学校
				$whereSql = ' school_id = '.$unit;
				//单位
				$schools = D('School')->getSchoolListByids(' AND ' . $whereSql);
				$return['unit'] = $schools[0]['school_name'];

			}else{
				$whereSql = ' town_id = '.$unit;
				//单位
				$town = D('Town')->getTownList(' AND ' . $whereSql);
				$return['unit'] = $town[0]['town_name'];
			}

			foreach($time as $k=>$v){
				list($year,$quarter) = explode('_',$v);
				//时间
				if($town > 0 && ($schools[0]['town_id'] == '110000' || $schools[0]['town_id'] == '110100')){
					$quarterStr =  $quarter . '季度、';
					$return['time'] .= $year.'年'.$quarterStr;
				}else{
					$return['time'] .= $year.'年'.($quarter==2?'下':'上').'半年、';
				}
				if($k==0){
					$sql = ' (year = '.$year.' AND quarter = '.$quarter.') ';
				}else{
					$sql .= ' OR (year = '.$year.' AND quarter = '.$quarter.') ';
				}
			}
			$groupby = 'year,quarter';
			$whereSql .= ' AND ('.$sql.')';
		}
		//生均数和面均数如果为0,取1
		//学生数量info_101003 教师数量 info_101002
		//面积info_101001

		$infounitname = D('Dict')->getDictName($infounit);
		$fieldstr = 'SUM(info_'.$infounit.')';


		$fields = $field.'ROUND('.$fieldstr.',4) AS `total`,ROUND(ROUND('.$fieldstr.',4)/IF((SUM(info_101003)+SUM(info_101002))>0,(SUM(info_101003)+SUM(info_101002)),1),4) AS `avgs`,ROUND(ROUND('.$fieldstr.',4)/IF(SUM(info_101001)>0,SUM(info_101001),1),4) AS `avgm`';

		$return['infounit'] = !empty($infounitname['unit'])?($infounitname['dict_name'].'（'.$infounitname['unit'].'）'):$infounitname['dict_name'];
		$return['data'] = $this->field($fields)->where($whereSql)->group($groupby)->order('total DESC')->select();

		$standard = D('Standard')->getStandardByinfo($infounit);

		foreach($return['data'] as $k=>$v){
			$num = ($k + 1) < 10 ? '0'.($k + 1) : ($k + 1);
			$return['data'][$k]['num'] = $num;
			if($town > 0){
				$school = D('School')->getSchoolListByids(' AND school_id = '.$v['school_id']);
				$return['data'][$k]['town'] = $school[0]['school_name'];
			}else{
				$towninfo = D('Town')->getTownList(' AND town_id = '.$v['town_id']);
				$return['data'][$k]['town'] = $towninfo[0]['town_name'];
			}
			
			$return['data'][$k]['dabiao'] = $v['avgs']>$standard['avgs']?'不合格':'合格';
			//市属高校和市教委直属直管单位按照季度上报，其余按照半年度上报
			$quarterStr = ($v['town_id'] == '110000' || $v['town_id'] == '110100') ? $v['quarter'] . '季度' : (($v['quarter']==2?'下':'上').'半年');
			$return['data'][$k]['yearStr'] = $v['year'].'年'.$quarterStr;
		}

		return $return;
	}
}
?>