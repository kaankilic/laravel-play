@extends('laravelplay::layouts.master')
@section('content')
@component('laravelplay::components.requirements',['requirements'=> $requirements['requirements'],'minVersion'=>$minVersion])
@slot('title')
<h3 class="title">PHP Requirements</h3>
@endslot
@endcomponent
@component('laravelplay::components.permissions',['permissions'=> $permissions['permissions']])
@slot('title')
<h3 class="title">Permissions</h3>
@endslot
@endcomponent
@if ($isReady)
<div class="level">
	<div class="level-left">
	</div>
	<div class="level-right">
		<a class="button is-primary" href="{{route('laravelplay::verification')}}">
			Next
		</a>
	</div>
</div>
@endif
@endsection
