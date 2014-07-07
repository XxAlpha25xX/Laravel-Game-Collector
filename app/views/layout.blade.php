<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Game Collector</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<a href="{{ action('GamesController@home') }}" class="navbar-brand">Games</a>
				<a href="{{ action('StudiosController@home') }}" class="navbar-brand">Studios</a>
				<a href="{{ action('MembersController@home') }}" class="navbar-brand">Members</a>
			</div>
		</nav>
		<h1></h1>
		@yield('content')
	</div>
</body>