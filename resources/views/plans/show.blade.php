@extends('layouts.app')

@section('mycssfile')
     <link href="{{ asset('css/custums/create_plan.css') }}" rel="stylesheet">
     <link href="{{ asset('css/custums/show.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="container">
            <div class="justify-content-md-center plan-cover" style="background-image: url({{ asset('images/plans/'. $plan->cover) }});">
                <div class="row">
                    <div class="col-md-5 offset-7">
                        <div class="row info-element fnt24">
                            <a class="fix-link" href="{{route('user_detail',['id'=>$plan->owner->id])}}">
                            <img class="cycle mini-avatar" src="{{asset($plan->owner->avatar)}}"/> {{$plan->owner->fullname}}
                            </a>
                        </div>
                        <div class="row info-element ">
                            <h4>{{$plan->title}}</h4>
                        </div>
                        <div class="row info-element ">
                            <h4><i class="fa fa-toggle-on"> {{ $plan->start_at }}</i></h4>
                            <h4><i class="fa fa-toggle-off"> {{ $plan->end_at }}</i></h4>
                        </div>
                        <div class="row info-element ">
                            <h4>
                                <i class="fa fa-group"> {{ $plan->num_join }}/{{ $plan->member }} </i>
                                <i class="fa fa-feed marleft15"> {{ $plan->num_follow }} </i>
                                <i class="fa fa-comments-o marleft15" id="count_comment"> {{ $plan->num_comment }}</i><br>
                                @if ($plan->status===1)
                                <i class="fa fa-ellipsis-h"> Planning</i>
                                @elseif ($plan->state===2)
                                <i class="fa fa-cogs"> Running</i>
                                @elseif ($plan->state===3)
                                <i class="fa fa-check-circle-o"> Ended</i>
                                @elseif ($plan->state===4)
                                <i class="fa fa-warning"> Cancled</i>
                                @endif
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="justify-content-md-center descreption">
                <h5>{{$plan->description}}</h5>
            </div>
        </div>
        
        @include('component.messages')

        <div class="row outside_title_map_and_guide" >
            <div class="col-md-8 text-center title_maps_and_guide bodright" >Map</div>
            <div class="col-md-4 text-center title_maps_and_guide bodleft" >Guide</div>
        </div>
        <div class="row custom_margin_map">
            <div class="col-md-8" id="map" ></div>
            <div class="col-md-4" id="right-panel"></div>
        </div>
        <div class="row custom_margin_table">
            <div class="col-md-12">       
                <table id="routes" class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Marker Start</th>
                            <th>Time Start</th>
                            <th>Marker End</th>
                            <th>Time End</th>
                            <th>Vehicle</th>
                            <th>Activities</th>
                        </tr>   
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <br>
        @if(Auth::check())
            @if($plan->owner->id != Auth::user()->id )
                <div class="row" style="margin-left: 20px; margin-right: 20px">        
                    <div class="col-md-6">
                        <div class="text-center">
                            <form action="{{ url('follow/' . $plan->id )}}">
                                <input type="submit" value="Follow" class="btn btn-lg btn-block btn-outline-primary"></input>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center">
                            <form action="{{ url('join/' . $plan->id )}}">
                                <input type="submit" value="Join" class="btn btn-lg btn-block btn-outline-success"></input>
                            </form>   
                        </div>
                    </div>
                </div>    
                
            @endif
        @endif
        
        @include('comment')
    </div>  

@endsection

@section('myjsfile')
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDdtVaJjFLyHdn0kTk9pF8upC4nNiLlqgM&libraries=places"></script>
    <script src="{{ asset('js/plans/show/init_map.js') }}"></script>
    
    <script src="{{ asset('js/plans/show/add_marker_for_show_function.js') }}"></script>
    <script src="{{ asset('js/plans/show/geocode_address_for_marker.js') }}"></script>
    <script src="{{ asset('js/plans/maps/redirect_and_display_function.js') }}" ></script>
    <script type="text/javascript">
        var routes = {!!json_encode($routes)!!};
    </script>
    <script type="text/javascript" src="{{ asset('js/plans/show/show.js') }}"></script>

@endsection