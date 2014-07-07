@extends('layout')

@section('content')
	<div class="page-header">
		<h1>Games <small>registered</small></h1>
	</div>
	<div class="panel panel-default">
		<div class="panel-body">
			<a href="{{ action('GamesController@create') }}" class="btn btn-primary">Create Game</a>
		</div>
	</div>
	@if ($games->isEmpty())
		<p>There are no games</p>
	@else
		<table class="table table-stripped">
			<thead>
				<tr>
					<th>Name</th>
					<th>Studio</th>
					<th>Members</th>
					<th>Release Date</th>
					<th>Cover</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($games as $game)
					<tr>
						<td>
							{{ $game->name }}
						</td>
						<td>
							<a href="" class="btn btn-default"> {{ $game->studio->name }}</a>
						</td>
						<td>
							<a href="" class="btn btn-default"> {{ $game->members->count() }}</a>
						</td>
						<td>
							{{ $game->release }}
						</td>
						<td>
							<img src="{{ $game->cover }}" style="height:35px;width:35px;border-radius:50px">
						</td>
						<td>
						<a href="{{ action('GamesController@edit',$game->id) }}" class="btn btn-default">Edit</a>
						<a href="{{ action('GamesController@delete',$game->id) }}" class="btn btn-danger">Delete</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@stop