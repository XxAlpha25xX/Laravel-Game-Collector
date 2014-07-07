<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('studios',function($table){
			$table->increments('id');
			$table->string('name',128);
			$table->date('founded');
			$table->string('logo',128);
			$table->timestamps();
			$table->integer('country_id')->unsigned();
		});

		Schema::table('studios',function($table){
			$table->foreign('country_id')->references('id')->on('countries');
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
		Schema::drop('studios');
	}

}
