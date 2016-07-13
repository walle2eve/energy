<?php
class StandardModel extends Model{
	public function getStandardData(){
		$list = $this->where('status = 1')->select();
		foreach($list as $k=>$row){
			$return[$row['info_id']] = $row;
		}
		return $return;
	}
	public function addStandardData($data){
		if(empty($data))return array('errno'=>1,'errtitle'=>'数据为空');

		$errnum = 0;
		foreach($data as $k=>$v){
			$return = $this->where('info_id = '.substr($k,5))->save(array('avgs'=>$v));
			//if(!$return){$errnum++;}
		}
		if($errnum > 0){
			$return = array('errno'=>2,'errtitle'=>'设置失败，请重试'); 
		}else{
			$return = array('errno'=>0,'errtitle'=>'设置成功'); 
		}
		return $return;
	}

	public function getStandardByinfo($info_id){
		
		return $this->where('info_id = '.$info_id)->find();
	}
}
?>