@extends('laravelplay::layouts.master')
@section('content')
<form action="{{route('laravelplay::user')}}" method="post">
	@csrf
	<div class="field">
		<div class="control">
			<label class="label">Name</label>
			<input type="text" name="name" class="input" />
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="label">E-Mail</label>
			<input type="text" name="email" class="input" />
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="label">Password</label>
			<input type="password" name="password" class="input" />
		</div>
	</div>
	<div class="level">
		<div class="level-left">
		</div>
		<div class="level-right">
			<button class="button is-primary" href="#">
				Next
			</button>
		</div>
	</div>
</form>
@stop
