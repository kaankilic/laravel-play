
{{ $title }}
@foreach($requirements as $type => $requirement)
<p class="tag {{ $minVersion['supported'] ? 'is-success' : 'is-danger' }}">
	{{ ucfirst($type) }} -
	@if($type == 'php')
	@if($minVersion['supported'])
	{{ $minVersion['current'] }}
	<i class="far fa-check-circle"></i>
	@else
	version {{ $minVersion['minimum'] }} required
	<i class="fas fa-exclamation-circle"></i>
	@endif
	@endif
</p>
@endforeach
<br />
@foreach($requirements[$type] as $extention => $enabled)
<div class="tag {{ $enabled ? 'is-success' : 'is-danger' }}">
	{{ $extention }}
	@if($enabled)
	<i class="far fa-check-circle"></i>
	@else
	<i class="fas fa-exclamation-circle"></i>
	@endif
</div>
@endforeach
