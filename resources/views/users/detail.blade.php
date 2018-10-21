@extends('layouts.app')

@section('mycssfile')
     <link href="{{ asset('css/custums/profile.css') }}" rel="stylesheet">
@endsection

@section('content')



<div class="row user-cover" style="background-image: url('{{asset($user->avatar)}}');">
	<img src="{{asset($user->avatar) }}" alt="Avatar" class="img-thumbnail user-avatar">
	<div class="col-md-5 offset-1 user-infor">
		<h2>{{$user->fullname}}</h2><br>
		<i class="fa fa-calendar font32"> {{$user->birthday}}</i><br>
		@if ($user->gender == 1)
		<i class="fa fa-mars font32 martop15"></i><br>
		@else
		<i class="fa fa-venus font32 martop15"></i><br>
		@endif
        <i class="fa fa-envelope font32 martop15"> {{$user->email}}</i>
	</div>
</div>
<div class="row menu-bar">
	<!-- Nav pills -->
	<div class="col-md-3"></div>
	<ul class="nav nav-pills col-md-9" role="tablist">
		<li class="nav-item col-md-4 text-center">
			<a class="nav-link active fix-a" data-toggle="pill" href="#menu1">Plan</a>
		</li>
		<li class="nav-item col-md-4 text-center">
			<a class="nav-link fix-a" data-toggle="pill" href="#menu2">Follow</a>
		</li>
		<li class="nav-item col-md-4 text-center">
			<a class="nav-link fix-a" data-toggle="pill" href="#menu3">Join</a>
		</li>
	</ul>
</div>
<div class="row martop-20">
	<!-- Tab panes -->
    <div class="container-fluid tab-content col-md-10 offset-1">
    	<div id="menu1" class="tab-pane active "><br>
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th style="width: 25%">Description</th>
                        <th>Member</th>
                        <th></th>
                    </tr>    
                </thead>
                @foreach( $user->plans as $plan)
                    <tr>
                        <td><div class="title-fix">{{ $plan->title }}</div></td>
                        <td>
                            <div class="row">
                            <div class="col-md-11 description-fix">{{ $plan->description }}</div>
                            @if(strlen($plan->description)>=105)
                                <div class="col-md-1 dotdotdot">...</div>
                            @endif
                            </div>
                        </td>
                        <td>{{ $plan->member }}</td>
                        <td>
                            <a href="{{ url('plans/'. $plan->id )}}" class="btn btn-info">Detail</a>
                           
                            @if(Auth::check())
                                @if(Auth::user()->id == $user->id)
                                    &nbsp; <a href="{{ url('plans/'. $plan->id.'/edit' )}}" class="btn btn-secondary">Edit <i class="fa fa-edit"></i></a>
                                    @if($plan->status == 1)
                                        &nbsp;<a href="{{ url('plans/'. $plan->id.'/cancel' )}}" class="btn btn-warning">Cancel <i class="fa fa fa-times-rectangle"></i></a>
                                        &nbsp;<a href="{{ url('plans/'. $plan->id.'/start' )}}" class="btn btn-success">Start <i class="fa fa-calendar-check-o"></i></a>
                                    @endif
                                    &nbsp;<a href="{{ url('joiners/'. $plan->id )}}" class="btn btn-info">Joiners <i class="fa fa-users"></i></a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div id="menu2" class="container tab-pane fade"><br>  
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Member</th>
                        <th>Status</th>
                        <th></th>
                    </tr>    
                </thead>
                @foreach( $user->follows as $plan)
                    <tr>
                        <td><div class="title-fix">{{ $plan->title }}</div></td>
                        <td class="row">
                            <div class="col-md-11 description-fix">{{ $plan->description }}</div>
                            @if(strlen($plan->description)>=238)
                                <div class="col-md-1 dotdotdot">...</div>
                            @endif
                        </td>
                        <td>{{ $plan->member }}</td>
                        @if($plan->pivot->isRequest == 1)
                            <td>Request join</td>
                        @elseif($plan->pivot->isRequest == 2)
                            <td>Accepted Join</td>
                        @elseif($plan->pivot->isRequest == 0)
                            <td>Denied</td>
                        @else
                            <td>follow</td>
                        @endif
                        <td><a href="{{ url('plans/'. $plan->id )}}" class="btn btn-info">Detail</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div id="menu3" class="container tab-pane fade"><br>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Member</th>
                        <th></th>
                    </tr>    
                </thead>
                @foreach( $user->joins as $plan)
                    <tr>
                        <td><div class="title-fix">{{ $plan->title }}</div></td>
                        <td class="row">
                            <div class="col-md-11 description-fix">{{ $plan->description }}</div>
                            @if(strlen($plan->description)>=273)
                                <div class="col-md-1 dotdotdot">...</div>
                            @endif
                        </td>
                        <td>{{ $plan->member }}</td>
                        <td><a href="{{ url('plans/'. $plan->id )}}" class="btn btn-info">Detail</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
                                                
    </div>
</div>

@endsection