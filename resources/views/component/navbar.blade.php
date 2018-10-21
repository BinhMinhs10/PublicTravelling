<div class='sticky-top' >
	<nav class="navbar navbar-expand-md navbar-dark navblue">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsDefault">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ Request::is('home') ? 'active' : ''}}">
					<a class="nav-link" href="{{ route('home') }}">
						<i class="fa fa-home fnt24"></i>
						<span class="sr-only">(current)</span>
					</a>
				</li>
				<li class="nav-item {{ Request::is('plans/create') ? 'active' : ''}}">
					<a class="nav-link" href="{{ url ('plans/create') }}">
						<i class="fa fa-paper-plane fnt24"></i>
						Make a plan
					</a>
				</li>
			</ul>
			@auth
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ url('users/'. Auth::user()->id) }}">
						<img class="cycle" src="{{asset(Auth::user()->avatar)}}"/>
					</a>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->username }}</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01">
						<a class="dropdown-item" href="{{  route('profile') }}">Change Profile</a>
						<a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
					</div>
				</li>
			</ul>
			@endauth

			@guest
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="{{ route('login') }}">Log in</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="{{ route('signup') }}">Sign up</a>
				</li>
			</ul>			
			@endguest
		</div>
	</nav>
</div>