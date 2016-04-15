<?php
class MainAction extends Action {
	public $referUrl = '';
	public function _initialize() {
		$this->referUrl = $_SERVER['HTTP_REFERER'];
		//检测用户是否登录
		A('Index')->checkLogin();
		$this->assign('login_name',session('login_name'));
		$user_kind = session('user_kind');
		$this->assign('user_kind',$user_kind);
	}
	//首页
	public function index_main(){
		$this->display('Main:index');
	}
	// 各单位上报信息
	public function showAddStatus(){
		$user_kind = session('user_kind');
		$town_id = $this->_get('town_id',0);
		$list = D('Info')->getShowAddStatus($town_id);
		$this->assign('user_kind',$user_kind);
		$this->assign('list',$list);
		$this->assign('town_id',$town_id);
		$this->display();
	}
	//框架top
	public function header(){
		$this->assign('user_kind',session('user_kind'));
		$this->display();
	}
	//框架左侧菜单
	public function menu(){
		$user_kind = session('user_kind');
		switch($user_kind){
			case '301010':
				$user_kind_s = 'c';
				break;
			case '301020':
				$user_kind_s = 't';
				break;
			case '301030':
			case '301040':
				$user_kind_s = 's';
				break;
			default:
				$this->showStatus('用户属性错误，请重新登录');
				break;
		}
		$menulist = $this->MenuList($user_kind_s);

		$this->assign('user_kind',$user_kind);
		$this->assign('user_kind_s',$user_kind_s);
		$this->assign('menulist',$menulist);
		$this->display();
	}
	//用户左侧菜单列表
	private function MenuList($user_kind_s){
		$menulist = array();
		$townlist = D('Town')->getTownList();//AND town_id > 110000
		foreach($townlist as $v){
			array_push($menulist,array('menuid'=>$v['town_id'],'menuname'=>$v['town_name']));
		}
		if($user_kind_s == 's'){
			$menulist = D('School')->getSchoolOtherInfo(session('org_id'));
		}
		return $menulist;
	}

	//上报数据
	public function addInfo(){
		if('POST'===strtoupper($_SERVER['REQUEST_METHOD'])){
			$data = I('post.',0,'htmlspecialchars');
			$return = D('Info')->addInfo($data);

			if($return['errno']>0){
				$this->showStatus($return['errtitle'],'error',U('Main/addInfo'));
			}elseif($return['errno']==0){
				$this->showStatus($return['errtitle'],'success',U('Main/addInfo'));
			}else{
				$this->showStatus('操作失败','error',U('Main/addInfo'));
			}
			exit();
		}
		$selectTown = D('Town')->getTownSelect();
		$this->assign('townSelect',$selectTown);
		$this->display();
	}
	//区县上报年度汇总数据
	public function addTownYearCollect(){
		$user_kind = session('user_kind');
		//区县功能20150205
		if(301020!=$user_kind){
			$this->error('您没有权限执行本操作');
		}
		//区县ID
		$town_id = session('org_id');
		
		if(IS_POST){
			$data = I('post.',0,'htmlspecialchars');
			$return = D('TownYearCollect')->addInfo($data);

			if($return['errno']>0){
				$this->showStatus($return['errtitle'],'error',U('Main/addTownYearCollect'));
			}elseif($return['errno']==0){
				$this->showStatus($return['errtitle'],'success',U('Main/addTownYearCollect'));
			}else{
				$this->showStatus('操作失败','error',U('Main/addInfo'));
			}
			exit();
		}
		//区县列表
		$selectTown = D('Town')->getTownSelect($town_id);
		$this->assign('townSelect',$selectTown);
		//已上报数据的年份列表
		$years = D('Info')->getYear();
		$this->assign('years',$years);
		$this->display();
	}
	//查看数据
	public function showInfo(){
		
		$id = $this->_get('id');
		if(!$id){$this->showStatus('参数错误');}
		$ac = in_array($this->_get('ac'),array('Info','TownYearCollect')) ? $this->_get('ac') : 'Info';
		
		$info = D($ac)->getInfoById($id);
		if(empty($info))$this->showStatus('该信息不存在或已被删除！');
		//各项折标，及生均面均数
		$stdList = D('Std')->getStdList();
		$stdInfos = array();
		foreach($stdList as $k=>$row){
			$stdInfos[$row['std_id']] = $row;
		}
		//total
		$totals = ($info['info_101002']+$info['info_101003'])>0?($info['info_101002']+$info['info_101003']):1;
		$totalm = $info['info_101001'] > 0 ? $info['info_101001'] : 1;
		//总电量
		$info['zb_101010'] = round($info['info_101010'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
		$info['avgs_101010'] = round($info['info_101010']/$totals,4);
		$info['avgm_101010'] = round($info['info_101010']/$totalm,4);
		//市电用电量
		$info['zb_101044'] = round($info['info_101044'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
		$info['avgs_101044'] = round($info['info_101044']/$totals,4);
		$info['avgm_101044'] = round($info['info_101044']/$totalm,4);
		//机房用电量
		$info['zb_101042'] = round($info['info_101042'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
		$info['avgs_101042'] = round($info['info_101042']/$totals,4);
		$info['avgm_101042'] = round($info['info_101042']/$totalm,4);
		//太阳能等发电量
		$info['zb_101046'] = round($info['info_101046'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);

		//总用水量
		$info['avgs_101012'] = round($info['info_101012']/$totals,4);
		$info['avgm_101012'] = round($info['info_101012']/$totalm,4);
		//中水用水量
		$info['avgs_101048'] = round($info['info_101048']/$totals,4);
		$info['avgm_101048'] = round($info['info_101048']/$totalm,4);

		//煤消耗量
		$info['avgs_101014'] = round($info['info_101014']/$totals,4);
		$info['avgm_101014'] = round($info['info_101014']/$totalm,4);
		
		//液化石油气
		$info['zb_101018'] = round($info['info_101018'] * $stdInfos['101018']['zbzmxs'] * $stdInfos['101018']['coef'],4);
		$info['avgs_101018'] = round($info['info_101018']/$totals,4);
		$info['avgm_101018'] = round($info['info_101018']/$totalm,4);
		//天然气
		$info['zb_101016'] = round($info['info_101016'] * $stdInfos['101016']['zbzmxs'] * $stdInfos['101016']['coef'],4);
		$info['avgs_101016'] = round($info['info_101016']/$totals,4);
		$info['avgm_101016'] = round($info['info_101016']/$totalm,4);
		//人工煤气
		$info['avgs_101020'] = round($info['info_101020']/$totals,4);
		$info['avgm_101020'] = round($info['info_101020']/$totalm,4);
		//热力
		$info['zb_101036'] = round($info['info_101036'] * $stdInfos['101036']['zbzmxs'] * $stdInfos['101036']['coef'],4);
		$info['avgs_101036'] = round($info['info_101036']/$totals,4);
		$info['avgm_101036'] = round($info['info_101036']/$totalm,4);
		//汽油
		$info['zb_101022'] = round($info['info_101022'] * $stdInfos['101022']['zbzmxs'] * $stdInfos['101022']['coef'],4);
		$info['avgs_101022'] = round($info['info_101022']/$totals,4);
		$info['avgm_101022'] = round($info['info_101022']/$totalm,4);		
		//柴油
		$info['zb_101028'] = round($info['info_101028'] * $stdInfos['101028']['zbzmxs'] * $stdInfos['101028']['coef'],4);
		$info['avgs_101028'] = round($info['info_101028']/$totals,4);
		$info['avgm_101028'] = round($info['info_101028']/$totalm,4);
		//煤油
		$info['zb_101034'] = round($info['info_101034'] * $stdInfos['101034']['zbzmxs'] * $stdInfos['101034']['coef'],4);
		$info['avgs_101034'] = round($info['info_101034']/$totals,4);
		$info['avgm_101034'] = round($info['info_101034']/$totalm,4);
		//其他能源
		$info['avgs_101040'] = round($info['info_101040']/$totals,4);
		$info['avgm_101040'] = round($info['info_101040']/$totalm,4);

		if($this->_get('viewType','') == 'downInfo' && $ac == 'Info'){
			header("Content-Type:text/html; charset=utf-8");

			$filename = $info['school_name'].'——'.$info['yearStr'].'能源信息表';

			$filename = urlencode($filename);

			header("Content-type: application/octet-stream;");
			header("Content-Disposition:attachment;filename=".$filename.".html");
			$content = '';
			$str = @file_get_contents ('./Public/downTemplate/downInfo.html');
			
			foreach ($info as $key=>$val){
				$str = str_replace('info[\''.$key.'\']',$val,$str);
			}

			echo $str;
			fclose($str);
			exit;
		}

		
		$this->assign('info',$info);
		$this->assign('referUrl',$this->referUrl);
		$this->display('show'.$ac);
	}

	//数据汇总
	public function collect(){
		$user_kind = session('user_kind');
		
		$ac = in_array($this->_get('ac'),array('Info','TownYearCollect')) ? $this->_get('ac') : 'Info';
		
		switch($user_kind){
			case '301010':
				$town_id = $this->_get('town',0);
				//区县年度汇总只包括17区县20150214
				$townList = D('Town')->getTownSelect($town_id,$ac);
				break;
			case '301020':
				$town_id = session('org_id');
				$townList = D('Town')->getTownSelect($town_id);
				break;
			case '301030':
			case '301040':
				$this->error('页面错误！');
				break;
			default:
				$this->error('用户身份有误');
				break;
		}
		
		/********************************************************/
		$years 			= D('Info')->field('year')->where('is_del = 0')->group('year')->select();
		$schoolTypes 	= D('Dict')->getSchTypesByTownid($town_id);
		
		$year 			= I('get.year',$years[0]['year']);
		$this->assign('year',$year);
		$schoolType 	= I('get.schoolType',0);
		$this->assign('schoolType',$schoolType);
		
		if($ac=="TownYearCollect")$townList = '<option value="99">全市汇总</option>' . $townList;
		$this->assign('townList',$townList);
		$this->assign('years',$years);
		$this->assign('schoolTypes',$schoolTypes);

		
		$showInfos = 0;
		$info = D($ac)->getInfoCollect($town_id,$year,$schoolType);
		//echo M()->getlastsql();
		/************************************************************/
		
		//if(empty($info))$this->showStatus('您选择的年度和单位类别数据为空');
		
		//各项折标，及生均面均数
		if(!empty($info)){
			$stdList = D('Std')->getStdList();
			$stdInfos = array();
			foreach($stdList as $k=>$row){
				$stdInfos[$row['std_id']] = $row;
			}
			//total
			$totals = ($info['info_101002']+$info['info_101003'])>0?($info['info_101002']+$info['info_101003']):1;
			$totalm = $info['info_101001'] > 0 ? $info['info_101001'] : 1;
			//总电量
			$info['zb_101010'] = round($info['info_101010'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
			$info['avgs_101010'] = round($info['info_101010']/$totals,4);
			$info['avgm_101010'] = round($info['info_101010']/$totalm,4);
			//市电用电量
			$info['zb_101044'] = round($info['info_101044'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
			$info['avgs_101044'] = round($info['info_101044']/$totals,4);
			$info['avgm_101044'] = round($info['info_101044']/$totalm,4);
			//机房用电量
			$info['zb_101042'] = round($info['info_101042'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);
			$info['avgs_101042'] = round($info['info_101042']/$totals,4);
			$info['avgm_101042'] = round($info['info_101042']/$totalm,4);
			//太阳能等发电量
			$info['zb_101046'] = round($info['info_101046'] * $stdInfos['101010']['zbzmxs'] * $stdInfos['101010']['coef'],4);

			//总用水量
			$info['avgs_101012'] = round($info['info_101012']/$totals,4);
			$info['avgm_101012'] = round($info['info_101012']/$totalm,4);
			//中水用水量
			$info['avgs_101048'] = round($info['info_101048']/$totals,4);
			$info['avgm_101048'] = round($info['info_101048']/$totalm,4);

			//煤消耗量
			$info['avgs_101014'] = round($info['info_101014']/$totals,4);
			$info['avgm_101014'] = round($info['info_101014']/$totalm,4);
			
			//液化石油气
			$info['zb_101018'] = round($info['info_101018'] * $stdInfos['101018']['zbzmxs'] * $stdInfos['101018']['coef'],4);
			$info['avgs_101018'] = round($info['info_101018']/$totals,4);
			$info['avgm_101018'] = round($info['info_101018']/$totalm,4);
			//天然气
			$info['zb_101016'] = round($info['info_101016'] * $stdInfos['101016']['zbzmxs'] * $stdInfos['101016']['coef'],4);
			$info['avgs_101016'] = round($info['info_101016']/$totals,4);
			$info['avgm_101016'] = round($info['info_101016']/$totalm,4);
			//人工煤气
			$info['avgs_101020'] = round($info['info_101020']/$totals,4);
			$info['avgm_101020'] = round($info['info_101020']/$totalm,4);
			//热力
			$info['zb_101036'] = round($info['info_101036'] * $stdInfos['101036']['zbzmxs'] * $stdInfos['101036']['coef'],4);
			$info['avgs_101036'] = round($info['info_101036']/$totals,4);
			$info['avgm_101036'] = round($info['info_101036']/$totalm,4);
			//汽油
			$info['zb_101022'] = round($info['info_101022'] * $stdInfos['101022']['zbzmxs'] * $stdInfos['101022']['coef'],4);
			$info['avgs_101022'] = round($info['info_101022']/$totals,4);
			$info['avgm_101022'] = round($info['info_101022']/$totalm,4);		
			//柴油
			$info['zb_101028'] = round($info['info_101028'] * $stdInfos['101028']['zbzmxs'] * $stdInfos['101028']['coef'],4);
			$info['avgs_101028'] = round($info['info_101028']/$totals,4);
			$info['avgm_101028'] = round($info['info_101028']/$totalm,4);
			//煤油
			$info['zb_101034'] = round($info['info_101034'] * $stdInfos['101034']['zbzmxs'] * $stdInfos['101034']['coef'],4);
			$info['avgs_101034'] = round($info['info_101034']/$totals,4);
			$info['avgm_101034'] = round($info['info_101034']/$totalm,4);
			//其他能源
			$info['avgs_101040'] = round($info['info_101040']/$totals,4);
			$info['avgm_101040'] = round($info['info_101040']/$totalm,4);
			
			if($this->_get('viewType','') == 'downInfo'){
				header("Content-Type:text/html; charset=utf-8");
				
				//导出区县汇总数据
				//2015-03-04
				$this->exportCollect($info);

				exit;
			}
			
			$showInfos = 1;
		}
		//print_r($info);
		$this->assign('town_id',$town_id);
		$this->assign('info',$info);
		$this->assign('showInfos',$showInfos);
		$this->assign('referUrl',$this->referUrl);
		
		$template = $ac=='TownYearCollect'?'Main:showTownYearCollect':'Main:showCollect';
		$this->display($template);
	}
	//修改数据
	public function editInfo(){
		if('POST'===strtoupper($_SERVER['REQUEST_METHOD'])){
			$data = I('post.',0,'htmlspecialchars');
			$return = D('Info')->editInfo($data);
			if($return['errno']>0){
				$this->showStatus($return['errtitle']);
			}elseif($return['errno']==0){
				$this->showStatus($return['errtitle'],'success');
			}else{
				$this->showStatus('操作失败');
			}
			exit();
		}
		$id = $this->_get('id');
		if(!$id){$this->showStatus('参数错误');}
		$info = D('Info')->getInfoById($id);
		if(empty($info))$this->showStatus('该信息不存在或已被删除！');
		$this->assign('info',$info);
		$this->assign('ac','edit');
		$this->display('Main:addInfo');	
	}
	//修改数据--区县汇总2015-02-12
	public function editTownCollectInfo(){
		if('POST'===strtoupper($_SERVER['REQUEST_METHOD'])){
			$data = I('post.',0,'htmlspecialchars');
			$return = D('TownYearCollect')->editInfo($data);
			if($return['errno']>0){
				$this->showStatus($return['errtitle']);
			}elseif($return['errno']==0){
				$this->showStatus($return['errtitle'],'success');
			}else{
				$this->showStatus('操作失败');
			}
			exit();
		}
		$id = $this->_get('id');
		if(!$id){$this->showStatus('参数错误');}
		$info = D('TownYearCollect')->getInfoById($id);
		if(empty($info))$this->showStatus('该信息不存在或已被删除！');
		$this->assign('info',$info);
		$this->assign('ac','edit');
		$this->display('Main:addTownYearCollect');	
	}
	//删除数据--区县汇总2015-02-12
	public function delTownCollectInfo(){
		//print_r($_SERVER);exit();
		$id = $this->_get('id');
		if(!$id){$this->showStatus('参数错误');}
		$return = D('TownYearCollect')->delInfo($id);
		if($return['errno']>0){
			$this->showStatus($return['errtitle']);
		}elseif($return['errno']==0){
			$this->showStatus($return['errtitle'],'success');
		}else{
			$this->showStatus('操作失败');
		}
	}
	//删除数据
	public function delInfo(){
		//print_r($_SERVER);exit();
		$id = $this->_get('id');
		if(!$id){$this->showStatus('参数错误');}
		$return = D('Info')->delInfo($id);
		if($return['errno']>0){
			$this->showStatus($return['errtitle']);
		}elseif($return['errno']==0){
			$this->showStatus($return['errtitle'],'success');
		}else{
			$this->showStatus('操作失败');
		}
	}

	//数据列表
	public function infolist(){

		$map['town_id'] = I('get.town_id',0);
		$map['school_type'] = I('get.school_type',0);
		$map['school_id'] = I('get.school_id',0);
		//$infolist = D('Info')->getInfoList($map);
		$selYear = I('get.selYear',0);
		
		if(session('user_kind') == '301030' || session('user_kind') == '301040'){
			$map = D('School')->getSchoolOtherInfo(session('org_id'));
		}
		
		if($selYear){
			list($map['year'],$map['quarter']) = explode('_',$selYear);
		}
		

		
		//年度下拉菜单
		$years = D('Info')->getYears($map);
		$this->assign('town_id',$map['town_id']);
		$this->assign('school_type',$map['school_type']);
		$this->assign('years',$years);

		$infolist = D('School')->getSchoolAndInfoList($map);

		$this->assign('page',$infolist['page']);
		$this->assign('list',$infolist['list']);
		$this->display();
	}
	//区县年度汇总数据列表2015-02-12
	public function towncollectlist(){

		$map['town_id'] = I('get.town_id',0);
		$map['year'] = I('get.selYear',0);
		
		//年度下拉菜单
		$years = D('Info')->getYear($map['year']);
		$this->assign('town_id',$map['town_id']);
		$this->assign('years',$years);

		$infolist = D('TownYearCollect')->getTownCollectList($map);

		$this->assign('page',$infolist['page']);
		$this->assign('list',$infolist['list']);
		$this->display();
	}
	//对比
	public function contrast(){
		$user_kind = session('user_kind');
		//选择区县的学校进行对比
		
		switch($user_kind){
			case '301010':
				$town = $this->_request('town');
				if($town){
					$this->contrast_t($this->_request());
				}else{
					cookie('town',0);
					$this->contrast_c($this->_request());
				}
				break;
			case '301020':
				$this->contrast_t($this->_request());
				break;
			default:
				$this->showStatus('您没有权限执行此操作！');
			break;
		}
	}

	//对比-市级
	private function contrast_c($map){
		//对比类型
		$ct = $map['ct'];
		if(!in_array($ct,array('unit','time'))){
			$this->display('Main:contrast_change_type');
			die();
		}
		$this->assign('ct',$ct);
		//单位
		$unit = $map['town_id'];
		//时间
		$time = $map['yearQuarter'];
		if(empty($unit)&&empty($time)){
			//单位
			$townList = D('Town')->getTownList(' AND town_id > 110100 ');
			//时间
			$timeList = D('Info')->getYearQuarters($map['town']);
			
			if($ct == 'time'){
				$parm['unitFormName'] = 'town_id';
				$parm['unitFormType'] = 'radio';
				$parm['timeFormName'] = 'yearQuarter[]';
				$parm['timeFormType'] = 'checkbox';
			}else{
				$parm['unitFormName'] = 'town_id[]';
				$parm['unitFormType'] = 'checkbox';
				$parm['timeFormName'] = 'yearQuarter';
				$parm['timeFormType'] = 'radio';
			}
	
			$this->assign('townList',$townList);
			$this->assign('timeList',$timeList);
			$this->assign('parm',$parm);
			$this->display('Main:contrast_change_unit_time');
			die();
		}
		if(empty($unit)||empty($time)){
			$this->showStatus('请选择对比单位和对比时间');
			die();
		}
		if($ct)cookie('ct',$ct);
		if($unit)cookie('unit',$unit);
		if($time)cookie('time',$time);

		$this->display('Main:contrast_change_info');
	}

	//对比-结果
	public function contrast_show(){

		$ct = cookie('ct');
		$unit = cookie('unit');
		$time = cookie('time');
		$town = cookie('town');

		if(!$ct||!$unit||!$time){
			$this->showStatus('请先选择对比类型对比单位及对比时间','error',U('Main/contrast'));
			die();
		}
		$info_unit = $this->_post('infounit');
		if(empty($info_unit)){
			$this->showStatus('请选择对比项');
			die();
		}
		$constrastList = D('Info')->contrast($info_unit,$town);

		if(empty($constrastList['data'])){$this->showStatus('当前选择的单位或时间无数据！');}
		$this->assign('ct',$ct);
		$this->assign('town',$town);
		$this->assign('info_unit',$info_unit);
		$this->assign('list',$constrastList);
		$this->display();	
	}

	//对比-区县
	private function contrast_t($map){
		$town = $this->_request('town');

		//对比类型
		$ct = $map['ct'];

		$this->assign('town',$town);
		if(!in_array($ct,array('unit','time'))){
			$this->display('Main:contrast_change_type');
			die();
		}
		$this->assign('ct',$ct);
		//单位
		$unit = $map['school_id'];
		//时间
		$time = $map['yearQuarter'];
		if(empty($unit)&&empty($time)){
			//单位
			if($town == 110000){
				$andWhere = ' AND LEFT(dict_id,4) = 2011';
			}elseif($town == 110100){
				$andWhere = ' AND LEFT(dict_id,4) = 2012';
			}else{
				$andWhere = ' AND LEFT(dict_id,4) = 2010';
			}
			$schoolTypes = D('Dict')->getDictListByUpid('201',$andWhere);

			//时间
			$timeList = D('Info')->getYearQuarters($map['town']);
			
			if($ct == 'time'){
				$parm['unitFormName'] = 'school_id';
				$parm['unitFormType'] = '';
				$parm['timeFormName'] = 'yearQuarter[]';
				$parm['timeFormType'] = 'checkbox';
			}else{
				$parm['unitFormName'] = 'school_id[]';
				$parm['unitFormType'] = 'multiple';
				$parm['timeFormName'] = 'yearQuarter';
				$parm['timeFormType'] = 'radio';
			}
	
			$this->assign('schoolTypes',$schoolTypes);
			$this->assign('timeList',$timeList);
			$this->assign('parm',$parm);
			$this->display('Main:contrast_t_change_unit_time');
			die();
		}
		if(empty($unit)||empty($time)){
			$this->showStatus('请选择对比单位和对比时间2');
			die();
		}
		if($ct)cookie('ct',$ct);
		if($unit)cookie('unit',$unit);
		if($time)cookie('time',$time);
		if($town)cookie('town',$town);

		$this->display('Main:contrast_change_info');
	}
	//排序
	public function orderby(){
		$user_kind = session('user_kind');
		//选择区县的学校进行排序
		switch($user_kind){
			case '301010':
				$town = $this->_request('town');
				if($town){
					$this->orderby_t($this->_request());
				}else{
					cookie('town',0);
					$this->orderby_c($this->_request());
				}
				break;
			case '301020':
				$this->orderby_t($this->_request());
				break;
			default:
				$this->showStatus('您没有权限执行此操作！');
			break;
		}
	}

	//排序-市级
	private function orderby_c($map){
		//排序类型
		$ct = $map['ct'];
		if(!in_array($ct,array('unit','time'))){
			$this->display('Main:orderby_change_type');
			die();
		}
		$this->assign('ct',$ct);
		//单位
		$unit = $map['town_id'];
		//时间
		$time = $map['yearQuarter'];
		if(empty($unit)&&empty($time)){
			//单位
			$townList = D('Town')->getTownList(' AND town_id > 110100 ');
			//时间
			$timeList = D('Info')->getYearQuarters($map['town']);
			
			if($ct == 'time'){
				$parm['unitFormName'] = 'town_id';
				$parm['unitFormType'] = 'radio';
				$parm['timeFormName'] = 'yearQuarter[]';
				$parm['timeFormType'] = 'checkbox';
			}else{
				$parm['unitFormName'] = 'town_id[]';
				$parm['unitFormType'] = 'checkbox';
				$parm['timeFormName'] = 'yearQuarter';
				$parm['timeFormType'] = 'radio';
			}
	
			$this->assign('townList',$townList);
			$this->assign('timeList',$timeList);
			$this->assign('parm',$parm);
			$this->display('Main:orderby_change_unit_time');
			die();
		}
		if(empty($unit)||empty($time)){
			$this->showStatus('请选择排序单位和排序时间');
			die();
		}
		if($ct)cookie('ct',$ct);
		if($unit)cookie('unit',$unit);
		if($time)cookie('time',$time);

		$this->display('Main:orderby_change_info');
	}

	//排序-结果
	public function orderby_show(){
		$town = cookie('town');
		$ct = cookie('ct');
		$unit = cookie('unit');
		$time = cookie('time');
		if(!$ct||!$unit||!$time){
			$this->showStatus('请先选择排序类型排序单位及排序时间','error',U('Main/orderby'));
			die();
		}
		$info_unit = $this->_post('infounit');
		if(empty($info_unit)){
			$this->showStatus('请选择排序项');
			die();
		}
		$orderbyList = D('Info')->orderby($info_unit,$town);
		if(empty($orderbyList['data'])){$this->showStatus('当前区县或时间无数据！');}
		$this->assign('ct',$ct);
		$this->assign('town',$town);
		$this->assign('info_unit',$info_unit);
		$this->assign('list',$orderbyList);
		$this->display();	
	}

	//排序-区县
	private function orderby_t($map){

		$town = $this->_request('town');

		//对比类型
		$ct = $map['ct'];

		$this->assign('town',$town);
		if(!in_array($ct,array('unit','time'))){
			$this->display('Main:orderby_change_type');
			die();
		}
		$this->assign('ct',$ct);
		//单位
		$unit = $map['school_id'];
		//时间
		$time = $map['yearQuarter'];
		if(empty($unit)&&empty($time)){
			//单位
			if($town == 110000){
				$andWhere = ' AND LEFT(dict_id,4) = 2011';
			}elseif($town == 110100){
				$andWhere = ' AND LEFT(dict_id,4) = 2012';
			}else{
				$andWhere = ' AND LEFT(dict_id,4) = 2010';
			}
			$schoolTypes = D('Dict')->getDictListByUpid('201',$andWhere);

			//时间
			$timeList = D('Info')->getYearQuarters($map['town']);
			
			if($ct == 'time'){
				$parm['unitFormName'] = 'school_id';
				$parm['unitFormType'] = '';
				$parm['timeFormName'] = 'yearQuarter[]';
				$parm['timeFormType'] = 'checkbox';
			}else{
				$parm['unitFormName'] = 'school_id[]';
				$parm['unitFormType'] = 'multiple';
				$parm['timeFormName'] = 'yearQuarter';
				$parm['timeFormType'] = 'radio';
			}
	
			$this->assign('schoolTypes',$schoolTypes);
			$this->assign('timeList',$timeList);
			$this->assign('parm',$parm);
			$this->display('Main:orderby_t_change_unit_time');
			die();
		}
		if(empty($unit)||empty($time)){
			$this->showStatus('请选择要排序的单位和时间2');
			die();
		}
		if($ct)cookie('ct',$ct);
		if($unit)cookie('unit',$unit);
		if($time)cookie('time',$time);
		if($town)cookie('town',$town);

		$this->display('Main:orderby_change_info');
	}

	//导出对比
	public function exportContrast(){
		$ct = cookie('ct');
		$town = cookie('town');
		$info_unit = $this->_get('info_unit');
		$constrastList = D('Info')->contrast($info_unit,$town);
		$this->exportExcel($constrastList,'constrast');
	}
	//导出排序
	public function exportOrderby(){
		$ct = cookie('ct');
		$town = cookie('town');
		$info_unit = $this->_get('info_unit');
		$orderbyList = D('Info')->orderby($info_unit,$town);
		$this->exportExcel($orderbyList,'orderby');
	}
	//导出区县汇总collect
	//2015-03-04
	private function exportCollect($info){
		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		$objPHPExcel = new PHPExcel();
		//模板文件
		$file = './Public/downTemplate/collect_template.xlsx';
		$objReader = PHPExcel_IOFactory::createReader('Excel2007');
		$objPHPExcel = $objReader->load($file);
		$objActSheet = $objPHPExcel->getActiveSheet();
		
		//缓存
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);
		//数据
		//面积
		$objActSheet->setCellValueExplicit('D4', $info['info_101001'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D5', $info['info_101038'],PHPExcel_Cell_DataType::TYPE_STRING);
		//用能人数
		$objActSheet->setCellValueExplicit('D7', $info['info_101002'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D8', $info['info_101004'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D9', $info['info_101003'],PHPExcel_Cell_DataType::TYPE_STRING);
		//公车情况
		$objActSheet->setCellValueExplicit('D11', $info['info_101005'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D12', $info['info_101006'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D13', $info['info_101007'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D14', $info['info_101008'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D15', $info['info_101009'],PHPExcel_Cell_DataType::TYPE_STRING);
		//总用电量
		$objActSheet->setCellValueExplicit('D17', $info['info_101010'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D18', $info['info_101011'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D19', $info['zb_101010'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D20', $info['avgs_101010'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D21', $info['avgm_101010'],PHPExcel_Cell_DataType::TYPE_STRING);
		//市电用电量
		$objActSheet->setCellValueExplicit('D22', $info['info_101044'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D23', $info['info_101045'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D24', $info['zb_101044'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D25', $info['avgs_101044'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D26', $info['avgm_101044'],PHPExcel_Cell_DataType::TYPE_STRING);
		//机房用电量
		$objActSheet->setCellValueExplicit('D27', $info['info_101042'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D28', $info['info_101043'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D29', $info['zb_101042'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D30', $info['avgs_101042'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D31', $info['avgm_101042'],PHPExcel_Cell_DataType::TYPE_STRING);
		//新能源发电用量
		$objActSheet->setCellValueExplicit('D32', $info['info_101046'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D33', $info['info_101047'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D34', $info['zb_101046'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D35', $info['avgs_101046'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D36', $info['avgm_101046'],PHPExcel_Cell_DataType::TYPE_STRING);
		//总用水量
		$objActSheet->setCellValueExplicit('D38', $info['info_101012'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D39', $info['info_101013'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D40', $info['avgs_101012'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D41', $info['avgm_101012'],PHPExcel_Cell_DataType::TYPE_STRING);
		//中水用量
		$objActSheet->setCellValueExplicit('D42', $info['info_101048'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D43', $info['info_101049'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D44', $info['avgs_101048'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D45', $info['avgm_101048'],PHPExcel_Cell_DataType::TYPE_STRING);
		//用煤情况
		$objActSheet->setCellValueExplicit('D47', $info['info_101014'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D48', $info['info_101015'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D49', $info['avgs_101014'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D50', $info['avgm_101014'],PHPExcel_Cell_DataType::TYPE_STRING);
		//1液化石油气用量（吨）
		$objActSheet->setCellValueExplicit('D52', $info['info_101018'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D53', $info['info_101019'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D54', $info['zb_101018'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D55', $info['avgs_101018'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D56', $info['avgm_101018'],PHPExcel_Cell_DataType::TYPE_STRING);
		//2天然气用量（万立方米）
		$objActSheet->setCellValueExplicit('D57', $info['info_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D58', $info['info_101017'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D59', $info['zb_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D60', $info['avgs_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D61', $info['avgm_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		//3人工煤气用量（万升）
		$objActSheet->setCellValueExplicit('D62', $info['info_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D63', $info['info_101017'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D64', $info['zb_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D65', $info['avgs_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D66', $info['avgm_101016'],PHPExcel_Cell_DataType::TYPE_STRING);
		//1汽油消耗量
		$objActSheet->setCellValueExplicit('D68', $info['info_101022'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D69', $info['info_101023'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D70', $info['zb_101022'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D71', $info['avgs_101022'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D72', $info['avgm_101022'],PHPExcel_Cell_DataType::TYPE_STRING);
		//其中车辆用油
		$objActSheet->setCellValueExplicit('D73', $info['info_101024'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D74', $info['info_101025'],PHPExcel_Cell_DataType::TYPE_STRING);
		//其他用油
		$objActSheet->setCellValueExplicit('D75', $info['info_101026'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D76', $info['info_101027'],PHPExcel_Cell_DataType::TYPE_STRING);
		//2柴油消耗量
		$objActSheet->setCellValueExplicit('D77', $info['info_101028'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D78', $info['info_101029'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D79', $info['zb_101028'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D80', $info['avgs_101028'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D81', $info['avgm_101028'],PHPExcel_Cell_DataType::TYPE_STRING);
		//其中车辆用油
		$objActSheet->setCellValueExplicit('D82', $info['info_101030'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D83', $info['info_101031'],PHPExcel_Cell_DataType::TYPE_STRING);
		//其他用油
		$objActSheet->setCellValueExplicit('D84', $info['info_101032'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D85', $info['info_101033'],PHPExcel_Cell_DataType::TYPE_STRING);
		//3煤油消耗量
		$objActSheet->setCellValueExplicit('D86', $info['info_101034'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D87', $info['info_101035'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D88', $info['zb_101034'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D89', $info['avgs_101034'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D90', $info['avgm_101034'],PHPExcel_Cell_DataType::TYPE_STRING);
		//热力消耗量
		$objActSheet->setCellValueExplicit('D92', $info['info_101036'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D93', $info['info_101037'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D94', $info['zb_101036'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D95', $info['avgs_101036'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D96', $info['avgm_101036'],PHPExcel_Cell_DataType::TYPE_STRING);
		//7、其他能源消耗量
		$objActSheet->setCellValueExplicit('D98', $info['info_101040'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D99', $info['info_101041'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D100', $info['info_101040'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D101', $info['avgs_101040'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('D102', $info['avgm_101040'],PHPExcel_Cell_DataType::TYPE_STRING);
		
	//print_r($info);exit();
		/*****************************************************************************/
		$fileName = $info['town_name'] . $info['yearStr'] . '年度 '.$info['school_type_name'].' 数据汇总导出';
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		$ua = $_SERVER["HTTP_USER_AGENT"];

		$encoded_filename = urlencode($fileName);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);
		
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');

		if(preg_match("/MSIE/", $ua) || preg_match("/Trident\/7.0/", $ua)){
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xlsx"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xlsx"');
		} else {
			header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"');
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	//daochu
	private function exportExcel($data,$type = 'orderby'){

		Vendor('PHPExcel.PHPExcel');
		Vendor('PHPExcel.PHPExcel.IOFactory');
		$objPHPExcel = new PHPExcel();

		$objActSheet = $objPHPExcel->getActiveSheet();
		//缓存
		$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

		$objActSheet->setCellValueExplicit('A1', '单位：',PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('B1', $data['unit'],PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('A2', '时间：',PHPExcel_Cell_DataType::TYPE_STRING);
		$objActSheet->setCellValueExplicit('B2', $data['time'],PHPExcel_Cell_DataType::TYPE_STRING);

		if($type == 'orderby'){
			$ctname = cookie('ct') == 'unit' ? (cookie('town')>0?'学校':'区县') : '时间';
			$objActSheet->setCellValueExplicit('A4', '排序',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('B4', $ctname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('C4', '数据类型',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('D4', '消耗量',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('E4', '生均数',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('F4', '面均数',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('G4', '合格情况',PHPExcel_Cell_DataType::TYPE_STRING);

			foreach($data['data'] as $k=>$row){
				$ctname = cookie('ct') == 'unit' ? $row['town'] : $row['yearStr'];
				$objActSheet->setCellValueExplicit('A'.($k + 5), $row['num'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('B'.($k + 5), $ctname, PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('C'.($k + 5), $data['infounit'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('D'.($k + 5), $row['total'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('E'.($k + 5), $row['avgs'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('F'.($k + 5), $row['avgm'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('G'.($k + 5), $row['dabiao'],PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}else{
			$ctname = cookie('ct') == 'unit' ? (cookie('town')>0?'学校':'区县') : '时间';
			$objActSheet->setCellValueExplicit('A4', '数据类型',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('B4', $ctname, PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('C4', '总量',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('D4', '生均数',PHPExcel_Cell_DataType::TYPE_STRING);
			$objActSheet->setCellValueExplicit('E4', '面均数',PHPExcel_Cell_DataType::TYPE_STRING);

			foreach($data['data'] as $k=>$row){
				$ctname = cookie('ct') == 'unit' ? $row['town'] : $row['yearStr'];
				$objActSheet->setCellValueExplicit('A'.($k + 5), $data['infounit'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('B'.($k + 5), $ctname, PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('C'.($k + 5), $row['total'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('D'.($k + 5), $row['avgs'],PHPExcel_Cell_DataType::TYPE_STRING);
				$objActSheet->setCellValueExplicit('E'.($k + 5), $row['avgm'],PHPExcel_Cell_DataType::TYPE_STRING);
			}
		}
	
		/*****************************************************************************/
		$fileName = $type=='orderby'?'排序':'对比';
		
		$objPHPExcel->setActiveSheetIndex(0);
		
		$ua = $_SERVER["HTTP_USER_AGENT"];

		$encoded_filename = urlencode($fileName);
		$encoded_filename = str_replace("+", "%20", $encoded_filename);
		
		header('Content-Type: application/octet-stream');
		header('Content-Type: application/vnd.ms-excel');
		header('Cache-Control: max-age=0');

		if(preg_match("/MSIE/", $ua) || preg_match("/Trident\/7.0/", $ua)){
			header('Content-Disposition: attachment; filename="' . $encoded_filename . '.xlsx"');
		} else if (preg_match("/Firefox/", $ua)) {
			header('Content-Disposition: attachment; filename*="utf8\'\'' . $fileName . '.xlsx"');
		} else {
			header('Content-Disposition: attachment; filename="' . $fileName . '.xlsx"');
		}

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;
	}
	//市级管理员设置达标标准
	public function setStandard(){
		$user_kind = session('user_kind');
		if($user_kind != '301010')$this->showStatus('您没有权限执行本操作!');

		if('POST'===strtoupper($_SERVER['REQUEST_METHOD'])){
			$data = I('post.',0,'htmlspecialchars');
			$return = D('Standard')->addStandardData($data);
			if($return['errno']>0){
				$this->showStatus($return['errtitle'],'error',U('Main/setStandard'));
			}elseif($return['errno']==0){
				$this->showStatus($return['errtitle'],'success',U('Main/setStandard'));
			}else{
				$this->showStatus('操作失败','error',U('Main/showAddStatus'));
			}
			exit();
		}

		$data = D('Standard')->getStandardData();
		$this->assign('data',$data);
		$this->display();
	}
	//用户管理
	//市级用户和区县用户管理学校用户账号
	public function manager(){
		$user_kind = session('user_kind');
		if($user_kind != '301010' && $user_kind != '301020')$this->showStatus('您没有权限执行本操
		作!');

		$data = I('get.',0,'htmlspecialchars');
		if($data['town_id']){
			$selectTown = D('Town')->getTownSelect($data['town_id']);
			$org_id = $data['town_id'];
			if($data['school_id']){
				$org_id = $data['school_id'];
				$selectSchool = D('School')->getSchoolSelect($data['town_id'],$data['school_id']);
			}
			$userinfo = D('User')->getUserInfo($org_id);
			if(!$userinfo || $userinfo['errno']!=0){
				$this->showStatus($userinfo['errtitle']);
				exit();
			}
			$this->assign('userInfo',$userinfo);
		}else{
			$selectTown = D('Town')->getTownSelect();
			$selectSchool = '';
		}
		$this->assign('townSelect',$selectTown);
		$this->assign('schoolSelect',$selectSchool);
		$this->display();
	}

	//重置用户密码
	public function setUserPass(){
		$login_name = $this->_get('login_name');
		$this->assign('headTitle','修改密码');
		
		$this->assign('isManager',1);
		$this->assign('login_name',$login_name);
		$this->display();
	}

	private function showStatus($msg,$status = 'error',$referUrl = ''){
		if($referUrl == '')$referUrl = $this->referUrl;
		$this->$status($msg,$referUrl);
	}
}