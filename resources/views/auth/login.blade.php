@extends('layouts.app')
@section('mycssfile')
	<link href="{{ asset('css/custums/login.css') }}" rel="stylesheet">
@endsection
@section('content')
	<div class="row martop30 fix-color">
		<div class="col-md-3 offset-1">
			<h2 class="text-center">Login Now</h2>
			<form class="login-form" action="{{ url('login/required') }}" method="post">
			@csrf
			<div class="form-group">
				<label for="exampleInputEmail1" class="text-uppercase">Username</label>
				<input id="username" type="text" class="form-control{{ session('fail') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
				@if (session('fail'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ session('fail') }}</strong>
				</span>
				@endif
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1" class="text-uppercase">Password</label>
				<input id="password" type="password" class="form-control{{ session('fail') ? ' is-invalid' : '' }}" name="password" value="{{ old('password') }}" required autofocus>
				@if (session('fail'))
				<span class="invalid-feedback" role="alert">
					<strong>{{ session('fail') }}</strong>
				</span>
				@endif
			</div>


			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" class="form-check-input">
					<small>Remember Me</small>
				</label>
				<button type="submit" class="btn btn-login float-right">Submit</button>
			</div>

			</form>
			<div class="copy-text martop80 text-center">Created with <i class="fa fa-heart"></i> by <a href="">group2</a>
			</div>
		</div>

		@include('component.slide_login_register')
	</div>

@endsection