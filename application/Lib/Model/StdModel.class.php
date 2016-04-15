<?php
class StdModel extends Model{
	public function getStdList(){
		return $this->where('status = 1')->select();
	}
}
?>