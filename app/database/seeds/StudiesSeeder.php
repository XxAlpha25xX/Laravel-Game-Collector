<?php

class StudiesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return  void
     */

    public function run()
    {
        DB::table('studies')->delete();
        Study::create(array(
            'name'   =>  'Primary School',
            'icon'  =>  'http://game-collector.dev/img/Study_icons/primary.jpeg'
            ));
        Study::create(array(
            'name'   =>  'Secondary School',
            'icon'  =>  'http://game-collector.dev/img/Study_icons/secondary.jpeg'
            ));
        Study::create(array(
            'name'   =>  'High School',
            'icon'  =>  'http://game-collector.dev/img/Study_icons/high.jpeg'
            ));
        Study::create(array(
            'name'   =>  'College',
            'icon'  =>  'http://game-collector.dev/img/Study_icons/college.jpeg'
            ));
        Study::create(array(
            'name'   =>  'PhD',
            'icon'  =>  'http://game-collector.dev/img/Study_icons/phd.jpeg'
            ));
    }

}

 ?>