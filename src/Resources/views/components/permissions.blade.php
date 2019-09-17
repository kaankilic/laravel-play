{{$title}}
<div class="list is-hoverable">
	@foreach($permissions as $permission)
	<li class="list-item {{ $permission['isSet'] ? 'is-success' : 'is-danger' }}">
		<div class="level">
			<div class="level-left">
				<div class="level-item">
					{{ $permission['folder'] }}
				</div>
			</div>
			<div class="level-right">
				<div class="level-item">
					<i class="fa fa-{{ $permission['isSet'] ? 'check-circle' : 'exclamation-circle' }}"></i>
					{{ $permission['permission'] }}
				</div>
			</div>
		</div>
	</li>
	@endforeach
</div>
