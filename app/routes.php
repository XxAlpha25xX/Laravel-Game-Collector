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
	return Redirect::action('GamesController@home');
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

Route::get('/games_edit',function(){
	return Redirect::action('GamesController@home');
});

Route::get('/games_delete/{game}','GamesController@delete');

Route::get('/games_delete',function(){
	return Redirect::action('GamesController@home');
});

Route::post('/games_handle',array(
	'uses'	=>	'GamesController@handleForm',
	'before'	=>	'csrf'
	));

Route::get('/games_handle',function(){
	return Redirect::action('GamesController@home');
});

Route::post('/games_delete',array(
	'uses'	=>	'GamesController@handleDelete',
	'before'	=>	'csrf'
	));

/*
|-----------------
| Studios Routes |
|-----------------
*/

Route::model('studio','Studio');

Route::get('/studios','StudiosController@home');

Route::get('/studios_create','StudiosController@create');

Route::get('/studios_edit/{studio}','StudiosController@edit');

Route::get('/studios_edit',function(){
	return Redirect::action('StudiosController@home');
});

Route::get('/studios_delete/{studio}','StudiosController@delete');

Route::get('/studios_delete',function(){
	return Redirect::action('StudiosController@home');
});

Route::post('/studios_handle',array(
	'uses'	=>	'StudiosController@handleForm',
	'before'	=>	'csrf'
	));

Route::get('/studios_handle',function(){
	return Redirect::action('StudiosController@home');
});

Route::post('/studios_delete',array(
	'uses'	=>	'StudiosController@handleDelete',
	'before'	=>	'csrf'
	));

/*
|-----------------
| Members Routes |
|-----------------
*/

Route::model('member','Member');

Route::get('/members','MembersController@home');

Route::get('/members_create','MembersController@create');

Route::get('/members_edit/{member}','MembersController@edit');

Route::get('/members_edit',function(){
	return Redirect::action('MembersController@home');
});

Route::get('/members_delete/{member}','MembersController@delete');

Route::get('/members_delete',function(){
	return Redirect::action('MembersController@home');
});

Route::post('/members_handle',array(
	'uses'	=>	'MembersController@handleForm',
	'before'	=>	'csrf'
	));

Route::get('/members_handle',function(){
	return Redirect::action('MembersController@home');
});

Route::post('/members_delete',array(
	'uses'	=>	'MembersController@handleDelete',
	'before'	=>	'csrf'
	));

Route::get('/members_game_add/{member}','MembersController@addGame');

Route::get('/members_game_add',function(){
	return Redirect::action('MembersController@home');
});

Route::get('/members_game_remove/{member}','MembersController@removeGame');

Route::get('/members_game_remove',function(){
	return Redirect::action('MembersController@home');
});

Route::post('/members_game_handle',array(
	'uses'	=>	'MembersController@handleGame',
	'before'	=>	'csrf'
	));





