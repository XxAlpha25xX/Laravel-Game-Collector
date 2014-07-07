<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGames extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('games',function($table){
			$table->increments('id');
			$table->string('name',128);
			$table->string('cover',128);
			$table->date('release');
			$table->integer('studio_id')->unsigned();
			$table->foreign('studio_id')->references('id')->on('studios');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('games');
	}

}