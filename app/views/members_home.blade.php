@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Members <small>registered</small></h1>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ action('MembersController@create') }}" class="btn btn-primary">Create member</a>
		</div>
	</div>
	@if ($members->isEmpty())
		<p>There are no members</p>
	@else
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Country</th>
					<th>Role</th>
					<th>Studies</th>
					<th>Date of Birth</th>
					<th>Games</th>
					<th>Studio</th>
					<th>Face</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($members as $member)
					<tr>
						<td>
							{{ $member->name }}
						</td>
						<td>
							{{ $member->country->name }}
						</td>
						<td>
							{{ $member->role->name }}
						</td>
						<td>
							{{ $member->study->name }}
						</td>
						<td>
							{{ $member->bornt }}
						</td>
						<td>
							<a href="" class="btn btn-default"> {{ $member->games->count() }}</a>
						</td>
						<td>
							<a href="" class="btn btn-default"> {{ $member->studio->name }}</a>
						</td>
						<td>
							<img src="{{ $member->face }}" style="height:35px;border-radius:50px">
						</td>
						<td>
						<a href="{{ action('MembersController@edit',$member->id) }}" class="btn btn-default">Edit</a>
						<a href="{{ action('MembersController@delete',$member->id) }}" class="btn btn-danger">Delete</a>
						<a href="{{ action('MembersController@addGame',$member->id) }}" class="btn btn-default">Add Game</a>
						<a href="{{ action('MembersController@removeGame',$member->id) }}" class="btn btn-default">Remove Game</a>
					</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop