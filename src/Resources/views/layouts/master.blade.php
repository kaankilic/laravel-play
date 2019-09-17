<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{config('app.name')}} Installation</title>

	{{-- Laravel Mix - CSS File --}}
	<link rel="stylesheet" href="{{ asset('/vendor/laravel-play/css/laravelplay.css') }}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
</head>
<body>
	<div id="app">
		<section class="section">
			<div class="columns is-centered">
				<div class="column is-half">
					<h1 class="title">Install the</h1>
					<h2 class="subtitle">{{config('app.name')}}</h2>
					@if(session()->has('error-message'))
					<b-message type="is-danger">
						{{session()->get('error-message')}}
					</b-message>
					@endif
					<div class="card">
						<div class="card-header">
							<div class="b-tabs">
								<nav class="tabs">
									<ul>
										<li class="@if(\Route::getCurrentRoute()->getName()=='laravelplay::') is-active @endif">
											<a href="javascript: void(0)"><span>Requirements</span></a>
										</li>
										<li class="@if(\Route::getCurrentRoute()->getName()=='laravelplay::verification') is-active @endif">
											<a href="javascript: void(0)"><span>Verify</span></a>
										</li>
										<li class="@if(\Route::getCurrentRoute()->getName()=='laravelplay::database') is-active @endif">
											<a href="javascript: void(0)"><span>Database</span></a>
										</li>
										<li class="@if(\Route::getCurrentRoute()->getName()=='laravelplay::settings') is-active @endif">
											<a href="javascript: void(0)"><span>Settings</span></a>
										</li>
										<li class="@if(\Route::getCurrentRoute()->getName()=='laravelplay::user') is-active @endif">
											<a href="javascript: void(0)"><span>User</span></a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
						<div class="card-body">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	{{-- Laravel Mix - JS File --}}
	<script src="{{ asset('/vendor/laravel-play/js/laravelplay.js') }}"></script>
</body>
</html>
