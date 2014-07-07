<?php 

class Member extends Eloquent {

	public function games(){
		return $this->belongsToMany('Game');
	}

	public function studio(){
		return $this->belongsTo('Studio');
	}

	public function country(){
		return $this->belongsTo('Country');
	}

	public function role(){
		return $this->belongsTo('Role');
	}

	public function study(){
		return $this->belongsTo('Study');
	}
}

?>