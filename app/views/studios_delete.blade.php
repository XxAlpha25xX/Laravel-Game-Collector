@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Delete {{ $studio->name}}<small> from listing</small></h1>
	</div>

	{{ Form::open(array(
		'action'	=>	'StudiosController@handleDelete',
		'method'	=>	'POST',
		'accept-charset'	=>'ISO-8859-1',
		'class'	=>	'form-group'
		))
	}}

	{{ Form::hidden('id',$studio->id) }}
	{{ Form::submit('Yes',array('class'	=>	'btn btn-danger')) }}
	<a href="{{ action('StudiosController@home') }}" class="btn btn-default">No</a>
	{{ Form::close() }}

@stop
