@extends('layouts.app')

@section('content')
    <br/><h1>Edit Your Profile</h1><br/>
	<div class="container">
		<form method="POST" enctype="multipart/form-data" action="{{ url('signup/changed') }}" aria-label="{{ __('Profile') }}">
            @csrf
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="oldAvatar" value="{{ $user->avatar }}">
            <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                <div class="col-md-6">
                    <input disabled id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ $user->username }}" required autofocus>

                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="fullname" class="col-md-4 col-form-label text-md-right">{{ __('Full Name') }}</label>

                <div class="col-md-6">
                    <input id="fullname" type="text" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" value="{{ $user->fullname }}" required autofocus>

                    @if ($errors->has('fullname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fullname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="form-group row">
                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

                <div class="col-md-6">
                    <select id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }} custom-select" name="gender">
                        <option value="0" 
                        @if($user->gender == '0')
							selected
                    	@endif
                         >female</option>
                        <option value="1"
						@if($user->gender == '1')
							selected
                    	@endif
                        >male</option>
                    </select>
                    

                    @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="birthday" class="col-md-4 col-form-label text-md-right">{{ __('Birthday') }}</label>

                <div class="col-md-6">
                    
                    <input id="birthday" type="text" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" value="{{ $user->birthday }}" required autofocus>
                    <script>
                        jQuery('#birthday').datetimepicker({
                            timepicker:false,
                            format:'Y-m-d'
                        });
                    </script>
                    @if ($errors->has('birthday'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            @if($user->avatar)
				<div >
					<img src="{{ asset($user->avatar) }} " alt="Avatar" style="width: 550px; height: 300px; margin: auto; display: block;">
				</div>
				<br/>
            @endif
			
            <div class="form-group row">
                <label for="avatar" class="col-md-4 col-form-label text-md-right">{{ __('Avatar') }}</label>

                <div class="col-md-6">
                    <input id="avatar" type="file" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" name="avatar" value="{{ $user->avatar }}" autofocus>

                    @if ($errors->has('avatar'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('avatar') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-success">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
	</div>
@endsection

@section('sidebar')
    @parent
    <p>This is appended to the sidebar</p>

@endsection