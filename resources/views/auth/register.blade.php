@extends('layouts.app')
@section('mycssfile')
    <link href="{{ asset('css/custums/login.css') }}" rel="stylesheet">
	<link href="{{ asset('css/custums/register.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row error">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
	<div class="row martop30 fix-color">
		@include('component.slide_login_register')
		<div class="col-md-4 fix-form-register">
            <!-- multistep form -->
            <form id="msform"  enctype="multipart/form-data" action="{{ url('signup/required') }}" method="post">
                @csrf
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Account Setup</li>
                    <li>Social Profiles</li>
                    <li>Personal Details</li>
                </ul>

                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Create your account</h2>
                    <h3 class="fs-subtitle">This is step 1</h3>

                    <input type="text" id="username" placeholder="Username" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus/>
                    @if ($errors->has('username'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif

                    <input type="password" id="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  required autofocus/>
                     @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                    <input type="password" id="password_confirmation" placeholder="Confirm Password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required autofocus/>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif

                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>

                <fieldset>
                    <h2 class="fs-title">Social Profiles</h2>
                    <h3 class="fs-subtitle">Your presence on the social network</h3>
                    <div id="imgCover" style="background-image: url('{{asset('/images/avatars/default_avatar.png')}}');" class="img-thumbnail custom_cover form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" alt="Cover">
                            <div class=" row custom_cover_imgae_space" ></div>
                            <div class=" row justify-content-center custom_link_upload_cover" >
                                <a style="color: white" href="#" onclick="$('#avatar').click();">Upload Avatar</a></div>
                           <input id="avatar" type="file" style="display: none"  name="avatar" accept="image/*" >

                            @if ($errors->has('avatar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('avatar') }}</strong>
                                </span>
                            @endif
                        
                    </div>
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>

                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <h3 class="fs-subtitle">We will never sell it</h3>

                    <input type="text" id="fullname" placeholder="Full Name" class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}" name="fullname" value="{{ old('fullname') }}" required autofocus/>
                    @if ($errors->has('fullname'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fullname') }}</strong>
                        </span>
                    @endif

                    <input type="text" id="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required/>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                    <input type="text" id="birthday" placeholder="Birthday" class="form-control{{ $errors->has('birthday') ? ' is-invalid' : '' }}" name="birthday" value="{{ old('birthday') }}" required autofocus/>
                    <script>
                        jQuery('#birthday').datetimepicker({
                            timepicker:false,
                            format:'Y-m-d',
                            maxDate: Date.now()
                        });
                    </script>
                    @if ($errors->has('birthday'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('birthday') }}</strong>
                        </span>
                    @endif  
                    
                    <select id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }} custom-select" name="gender">
                        <option value='-1' selected>Open this select gender</option>
                        <option value="0">female</option>
                        <option value="1">male</option>
                    </select>   
                    @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif  

                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="submit" id="submit" class="submit action-button" value="Submit" />
                </fieldset>
            </form>
			<div class="copy-text martop80 text-center">Created with <i class="fa fa-heart"></i> by <a href="">group2</a>
			</div>
		</div>

	</div>

@endsection
@section('myjsfile')
    <script src="{{ asset('js/jquery.easing.js') }}"></script>
    <script src="{{ asset('js/auth/register.js') }}"></script>
    <script src="{{asset('js/plans/preview_img.js')}}"></script>
    <script src="{{asset('js/auth/validate_register.js')}}"></script>
@endsection