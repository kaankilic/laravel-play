@extends('laravelplay::layouts.master')
@section('content')
<form action="{{route('laravelplay::settings')}}" method="post">
	@csrf
	<div class="field">
		<div class="control">
			<label class="label">Application Name</label>
			<input type="text" name="app_name" value="{{$inputs['app_name']}}" class="input" />
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="label">Application URL</label>
			<input type="text" name="app_url" value="{{$inputs['app_url']}}" class="input" />
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
