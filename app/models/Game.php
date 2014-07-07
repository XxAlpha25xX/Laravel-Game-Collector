<?php 

class Game extends Eloquent {

	public function members(){
		return $this->belongsToMany('Member');
	}

	public function studio(){
		return $this->belongsTo('Studio');
	}
}

?>