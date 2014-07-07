@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Delete {{ $game->name}}<small>from collection</small></h1>
	</div>

	{{ Form::open(array(
		'action'	=>	'GamesController@handleDelete',
		'method'	=>	'POST',
		'accept-charset'	=>'ISO-8859-1',
		'class'	=>	'form-group'
		))
	}}

	{{ Form::hidden('id',$game->id) }}
	{{ Form::submit('Yes',array('class'	=>	'btn btn-danger')) }}
	<a href="{{ action('GamesController@home') }}" class="btn btn-default">No</a>
	{{ Form::close() }}
@stop
