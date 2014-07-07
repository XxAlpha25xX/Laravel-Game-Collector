<?php 
	
class Role extends Eloquent {

	public function members(){
		return $this->hasMany('Member');
	}

}

?>