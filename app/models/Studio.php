<?php 

class Studio extends Eloquent {
	
	public function games(){
		return $this->hasMany('Game');
	}

	public function members(){
		return $this->hasMany('Member');
	}

	public function country(){
		return $this->belongsTo('Country');
	}
}

?>