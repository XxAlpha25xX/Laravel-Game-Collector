@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Delete {{ $member->name}}<small> from collection</small></h1>
	</div>

	{{ Form::open(array(
		'action'	=>	'MembersController@handleDelete',
		'method'	=>	'POST',
		'accept-charset'	=>'ISO-8859-1',
		'class'	=>	'form-group'
		))
	}}

	{{ Form::hidden('id',$member->id) }}
	{{ Form::submit('Yes',array('class'	=>	'btn btn-danger')) }}
	<a href="{{ action('MembersController@home') }}" class="btn btn-default">No</a>
	{{ Form::close() }}

@stop
