<?php
class TownModel extends Model{
	public function getTownList($whereSql = '',$ac="Info"){
		$user_kind = session('user_kind');
		$where = '';
		switch($user_kind){
			case '301010':
				$where = '1=1';
				break;
			case '301020':
				$where = 'town_id = '.session('org_id');
				break;
			case '301030':
			case '301040':
				$town_id = D('School')->getTownId(session('org_id'));
				$where = 'town_id = '.$town_id;
				break;
			default:
				$where = '1=0';
				break;
		}
		if($whereSql!='')$where .= ' '.$whereSql;
		if($ac=='TownYearCollect')$where .= ' AND town_id BETWEEN 110101 AND 110229';
		return $this->where($where)->order('orderby')->select();
	}

	public function getTownSelect($town_id=0,$ac="Info"){
		$townList = $this->getTownList('',$ac);
		$selstr = '';
		
		foreach($townList as $v){
			$selected = '';
			if($town_id == $v['town_id']){
				$selected = 'selected=selected';
			}
			$selstr .= "<option value=\"{$v['town_id']}\" {$selected}>{$v['town_name']}</option>";
		}
		return $selstr;
	}
}
?>