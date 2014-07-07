@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Add Game <small>to listing</small></h1>
	</div>
	<form action="{{ action('GamesController@handleCreate') }}" method="post" role="form">
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" name="name">
		</div>
		<div class="form-group">
			<label for="studio">Studio</label>
			<input type="text" class="form-control" name="studio">
		</div>
		<div class="form-group">
			<label for="release">Release Date</label>
			<input type="date" class="form-control" name="release">
		</div>
		<div class="form-group">
			<label for="cover">Cover</label>
			<input type="file" class="form-control" name="cover">
		</div>
		<input type="submit" value="Add" class="btn btn-primary" />
		<a href="{{action('GamesController@home')}}">Cancel</a>

	</form>
@stop