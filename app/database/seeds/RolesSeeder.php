<?php

class RolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return  void
     */

    public function run()
    {
        DB::table('roles')->delete();
        Role::create(array(
            'name'   =>  'Engine Programmer',
            'description'   =>  'Programmer of the base game enviroment.',
            'icon'  =>  'http://game-collector.dev/img/role_icons/engine_dev.jpeg'
            ));
        Role::create(array(
            'name'   =>  '3D Artist',
            'description'   =>  '3D Graphics sketch and design artist.',
            'icon'  =>  'http://game-collector.dev/img/role_icons/3dartist_dev.jpeg'
            ));
        Role::create(array(
            'name'   =>  'Music FX Producer',
            'description'   =>  'Sound effects and sound tracks producer.',
            'icon'  =>  'http://game-collector.dev/img/role_icons/musicproducer_dev.jpeg'
            ));
        Role::create(array(
            'name'   =>  '2D Artist',
            'description'   =>  '2D Graphics sketch and design artist..',
            'icon'  =>  'http://game-collector.dev/img/role_icons/3dartist_dev.jpeg'
            ));
        Role::create(array(
            'name'   =>  'Game Scripter',
            'description'   =>  'Front-end game scripter.',
            'icon'  =>  'http://game-collector.dev/img/role_icons/engine_dev.jpeg'
            ));
    }

}

 ?>