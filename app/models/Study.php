<?php 
	
class Study extends Eloquent {

	public function members(){
		return $this->hasMany('Member');
	}

}

?>