@extends('laravelplay::layouts.master')
@section('content')
<form action="{{route('laravelplay::database')}}" method="post">
	@csrf
	<div class="field">
		<div class="control">
			<label class="label">Host</label>
			<input type="text" name="host" value="{{$inputs['db_host']}}" class="input" />
		</div>
	</div>
	<div class="columns">
		<div class="column">
			<div class="field">
				<div class="control">
					<label class="label">MySQL User</label>
					<input type="text" name="db_username" value="{{$inputs['db_username']}}" class="input" />
				</div>
			</div>
		</div>
		<div class="column">
			<div class="field">
				<div class="control">
					<label class="label">MySQL Password</label>
					<input type="text" name="db_password" value="{{$inputs['db_password']}}" class="input" />
				</div>
			</div>
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="label">DB Name</label>
			<input type="text" name="db_name" value="{{$inputs['db_database']}}" class="input" />
		</div>
	</div>
	<div class="level">
		<div class="level-left">
		</div>
		<div class="level-right">
			<button class="button is-primary">
				Next
			</button>
		</div>
	</div>
</form>
@stop
