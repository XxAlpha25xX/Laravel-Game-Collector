<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',function(){
	return 'You are on the main page! Try /games /studios /members url!';
});


/*
|---------------
| Games Routes |
|---------------
*/

Route::model('game','Game');

Route::get('/games','GamesController@home');

Route::get('/games_create','GamesController@create');

Route::get('/games_edit/{game}','GamesController@edit');

Route::get('/games_delete/{game}','GamesController@delete');

Route::post('/games_handle',array(
	'uses'	=>	'GamesController@handleForm',
	'before'	=>	'csrf'
	));

Route::post('/games_delete','GamesController@handleDelete');


/*
|-----------------
| Studios Routes |
|-----------------
*/

Route::model('studio','Studio');

Route::get('/studios','StudiosController@home');

Route::get('/studios_create','StudiosController@create');

Route::get('/studios_delete/{studio}','StudiosController@delete');

Route::get('/studios_edit/{studio}','StudiosController@edit');

Route::post('/studios_handle',array(
	'uses'	=>	'StudiosController@handleForm',
	'before'	=>	'csrf'
	));

Route::post('/studios_delete','StudiosController@handleDelete');

/*
|-----------------
| Members Routes |
|-----------------
*/

Route::model('member','Member');

Route::get('/members','MembersController@home');

Route::get('/members_create','MembersController@create');

Route::get('/members_edit/{member}','MembersController@edit');

Route::get('/members_delete/{member}','MembersController@delete');

Route::post('/members_handle',array(
	'uses'	=>	'MembersController@handleForm',
	'before'	=>	'csrf'
	));

Route::get('/members_game_add/{member}','MembersController@addGame');

Route::get('/members_game_remove/{member}','MembersController@removeGame');

Route::post('/members_game_handle','MembersController@handleGame');

Route::post('/members_delete','MembersController@handleDelete');




