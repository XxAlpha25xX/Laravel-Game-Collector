<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		//Seed the countries
		$this->call('CountriesSeeder');
		$this->command->info('Seeded the countries!');
		$this->call('RolesSeeder');
		$this->command->info('Seeded the roles!');
		$this->call('StudiesSeeder');
		$this->command->info('Seeded the studies!');
	}

}
