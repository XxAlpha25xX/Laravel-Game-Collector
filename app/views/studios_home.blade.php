@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Studios <small>registered</small></h1>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ action('StudiosController@create') }}" class="btn btn-primary">Create studio</a>
		</div>
	</div>
	@if ($studios->isEmpty())
		<p>There are no studios</p>
	@else
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Country</th>
					<th>Foundation Date</th>
					<th>Games</th>
					<th>Members</th>
					<th>Logo</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($studios as $studio)
					<tr>
						<td>
							{{ $studio->name }}
						</td>
						<td>
							{{ $studio->country->name }}
						</td>
						<td>
							{{ $studio->founded }}
						</td>
						<td>
							<a href="{{ action('StudiosController@edit', $studio->id) }}" class="btn btn-default"> {{ $studio->games->count() }}</a>
						</td>
						<td>
							<a href="{{ action('StudiosController@edit', $studio->id) }}" class="btn btn-default"> {{ $studio->members->count() }}</a>
						</td>
						<td>
							<img src="{{ $studio->logo }}" style="height:35px;width:35px;border-radius:50px">
						</td>
						<td>
						<a href="{{ action('StudiosController@edit',$studio->id) }}" class="btn btn-default">Edit</a>
						<a href="{{ action('StudiosController@delete',$studio->id) }}" class="btn btn-danger">Delete</a>
					</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop