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
	{{ Form::label('role','Role') }}
		<select name="role" class="form-control">
		@foreach($roles as $role)
			@if($role->id==$fields_old['role'])
				<option value="{{ $role->id }}" selected> {{ $role->name }} </option>
			@else
				<option value="{{ $role->id }}"> {{ $role->name }} </option>
			@endif
		@endforeach
		</select>
	</div>


	<div class="form-group">
	{{ Form::label('study','Study') }}
		<select name="study" class="form-control">
		@foreach($studies as $study)
			@if($study->id==$fields_old['study'])
				<option value="{{ $study->id }}" selected> {{ $study->name }} </option>
			@else
				<option value="{{ $study->id }}"> {{ $study->name }} </option>
			@endif
		@endforeach
		</select>
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
	{{ Form::label('bornt','Date of Birth') }}
	{{ Form::input('date', 'bornt', $fields_old['bornt'], array('class' => 'form-control')) }}
	</div>

	@if(isset($fields_old['face']))
		<div class="form-group">
			{{ Form::label('current_face','Current Face') }}
			<br/>
			<img src=" {{$fields_old['face'] }}" style="width:100px;">
		</div>
	@endif

	<div class="form-group">
	{{ Form::label('face','Face Photo') }}
	{{ Form::file('face',array('class'	=>	'form-control')) }}
	</div>

	{{ Form::submit('Add',array('class'	=>	'btn btn-primary')) }}
	<a href="{{action('MembersController@home')}}">Cancel</a>

	{{ Form::close() }}

@stop