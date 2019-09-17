@extends('laravelplay::layouts.master')
@section('content')
<form action="{{route('laravelplay::verification')}}" method="post">
	@csrf
	<div class="field">
		<div class="control">
			<label class="label">License</label>
			<input type="text" name="license_key" value="{{$inputs['license_key']}}" class="input" />
		</div>
	</div>
	<div class="field">
		<div class="control">
			<label class="label">Client</label>
			<input type="text" name="client" value="{{$inputs['license_client']}}" class="input" />
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
