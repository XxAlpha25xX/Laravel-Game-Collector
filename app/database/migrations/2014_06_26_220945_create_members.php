<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('members',function($table){
			$table->increments('id');
			$table->string('name',128);
			$table->date('bornt');
			$table->string('face',128);
			$table->integer('studio_id')->unsigned();
			$table->foreign('studio_id')->references('id')->on('studios');
			$table->integer('country_id')->unsigned();
			$table->foreign('country_id')->references('id')->on('countries');
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('roles');
			$table->integer('study_id')->unsigned();
			$table->foreign('study_id')->references('id')->on('studies');
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
		Schema::drop('members');
	}

}
