
@extends('layout')

@section('content')

	<div class="page-header">
		<h1>Remove game from {{ $member->name}}</h1>
	</div>

	{{ Form::open(array(
		'action'	=>	'MembersController@handleGame',
		'method'	=>	'POST',
		'accept-charset'	=>'ISO-8859-1',
		'class'	=>	'form-group'
		))
	}}

	<div class="form-group">
	{{ Form::label('game','Game to remove') }}
		<select name="game" class="form-control">
			@if ($games->isEmpty())
				<option value="0" selected>No games available.</option>
			@else
				@foreach($games as $game)
					<option value="{{ $game->id }}"> {{ $game->name }} </option>
				@endforeach
			@endif
		</select>
	</div>

	{{ Form::hidden('remove',1) }}
	{{ Form::hidden('id',$member->id) }}
	@if (!$games->isEmpty())
		{{ Form::submit('Yes',array('class'	=>	'btn btn-danger')) }}
	@endif
	<a href="{{ action('MembersController@home') }}" class="btn btn-default">Go back</a>
	{{ Form::close() }}

@stop
