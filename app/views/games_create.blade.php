@extends('layout')

@section('content')
	<div class="page-header">
		<h1>{{$title}} <small>to listing</small></h1>
	</div>

	<ul class="errors">
		@foreach($errors->all('<li>:message</li>') as $message)
			{{ $message }}
		@endforeach
	</ul>


	{{ Form::open(array(
		'url'	=>	$submit_to,
		'method'	=>	'POST',
		'accept-charset'	=>'ISO-8859-1',
		'files'	=>	'true',
		'class'	=>	'form-group'
		))
	}}

	@if(isset($id))
		{{ Form::hidden('id',$id) }}
	@endif

	<div class="form-group">
	{{ Form::label('name','Name') }}
	{{ Form::text('name',$fields_old['name'],array('class'	=>	'form-control')) }}
	</div>

	<div class="form-group">
	{{ Form::label('studio','Studio') }}
		<select name="studio" class="form-control">
			@if ($studios->isEmpty())
				<option value="0" selected>No studio available.</option>
			@else
				@foreach($studios as $studio)
					@if($studio->id==$fields_old['studio'])
						<option value="{{ $studio->id }}" selected> {{ $studio->name }} </option>
					@else
						<option value="{{ $studio->id }}"> {{ $studio->name }} </option>
					@endif
				@endforeach
			@endif
		</select>
	</div>


	<div class="form-group">
	{{ Form::label('release','Release Date') }}
	{{ Form::input('date', 'release', $fields_old['release'], array('class' => 'form-control')) }}
	</div>

	@if(isset($fields_old['cover']))
		<div class="form-group">
			{{ Form::label('current_cover','Current Cover') }}
			<br/>
			<img src=" {{$fields_old['cover'] }}" style="width:100px;">
		</div>
	@endif

	<div class="form-group">
	{{ Form::label('cover','Game Cover') }}
	{{ Form::file('cover',array('class'	=>	'form-control')) }}
	</div>

	{{ Form::submit('Add',array('class'	=>	'btn btn-primary')) }}
	<a href="{{action('GamesController@home')}}">Cancel</a>

	{{ Form::close() }}

@stop