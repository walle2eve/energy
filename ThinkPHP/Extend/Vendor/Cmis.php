<?php

class Cmis {

	public function get_cmis($cmis_key,$cmis,$cmis30id=""){
		if(empty($cmis_key)){
			$arr = array('error_code'=>'99');
			return json_encode($arr);
			exit;
		}elseif(empty($cmis)){
			$arr = array('error_code'=>'98');
			return json_encode($arr);
			exit;
		}else{			
			$json_string = @file_get_contents('http://api.ichzh.com/cmis/index.php/Index/get_cmis/?cmis_key='.$cmis_key.'&cmis='.$cmis.'&cmis30id='.$cmis30id);
			$obj=json_decode($json_string);
			return $obj;
			exit;
		}
		
	}

}