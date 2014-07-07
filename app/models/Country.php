<?php 

class Country extends Eloquent {

	public $table = 'countries';
	public $timestamps = false;

	public function studios(){
		return $this->hasMany('Studio');
	}

	public function members(){
		return $this->hasMany('Member');
	}
}

?>