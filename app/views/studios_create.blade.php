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
	{{ Form::label('country','Country') }}
		<select name="country" class="form-control">
		@foreach(array_keys($world_regions) as $region_name)
			<optgroup label="{{ $region_name }}">
				@foreach($world_regions[$region_name] as $country)
				@if($country->id==$fields_old['country'])
					<option value="{{ $country->id }}" selected> {{ $country->name }} </option>
				@endif
					<option value="{{ $country->id }}"> {{ $country->name }} </option>
				@endforeach
			</optgroup>
		@endforeach
		</select>
	</div>


	<div class="form-group">
	{{ Form::label('founded','Founded Date') }}
	{{ Form::input('date', 'founded', $fields_old['founded'], array('class' => 'form-control')) }}
	</div>

	@if(isset($fields_old['logo']))
		<div class="form-group">
			{{ Form::label('current_logo','Current Logo') }}
			<br/>
			<img src=" {{$fields_old['logo'] }}" style="width:100px;">
		</div>
	@endif

	<div class="form-group">
	{{ Form::label('logo','Studio Logo') }}
	{{ Form::file('logo',array('class'	=>	'form-control')) }}
	</div>

	{{ Form::submit('Add',array('class'	=>	'btn btn-primary')) }}
	<a href="{{action('StudiosController@home')}}">Cancel</a>

	{{ Form::close() }}

@stop