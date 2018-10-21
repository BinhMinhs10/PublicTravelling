@extends('layouts.app')

@section('mycssfile')
     <link href="{{ asset('css/custums/create_plan.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container-fluid">
        @include('component.carousel')
        <form id="createPlanForm" method="POST" enctype="multipart/form-data" action="{{ route('plans.store') }}">
        @csrf
        <div class="row martop30">

            <div class="col-md-6">
                <div class="row justify-content-center">
                    <h3 class="custm-title-h">Create Your Plan</h3>
                </div>
                <div class="row martop30">
                    <div class="col-md-4 text-right"><h4>Title</h4></div>
                    <div class="col-md-6 text-left">
                        <input id="title" type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>

                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif                        
                    </div>
                </div>

                <div class="row martop30">
                    <div class="col-md-4 text-right"><h4>Start at</h4></div>
                    <div class="col-md-6 text-left">
                        <input id="start_at" type="text" class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}" name="start_at">

                        @if ($errors->has('start_at'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('start_at') }}</strong>
                            </span>
                        @endif                        
                    </div>
                </div>

                <div class="row martop30">
                    <div class="col-md-4 text-right"><h4>End at</h4></div>
                    <div class="col-md-6 text-left">
                        <input id="end_at" type="text" class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}" name="end_at">

                        @if ($errors->has('end_at'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('end_at') }}</strong>
                            </span>
                        @endif                        
                    </div>
                </div>
                
                <div class="row martop30">
                    <div class="col-md-4 text-right"><h4>Member</h4></div>
                    <div class="col-md-6 text-left">
                        <input id="member" type="number" class="form-control{{ $errors->has('member') ? ' is-invalid' : '' }}" min="0" name="member" value="{{ old('member') }}" required autofocus>

                        @if ($errors->has('member'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('member') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row martop30">
                    <div class="col-md-4 text-right"><h4>Description</h4></div>
                    <div class="col-md-6 text-left">
                        <textarea id="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }} fix-textarea" name="description" value="{{ old('description') }}" required autofocus></textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif                        
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div id="imgCover" style="background-image: url('{{asset('/images/plans/cover_default.png')}}');" class="img-thumbnail custom_cover" alt="Cover">
                        <div class=" row custom_cover_imgae_space" ></div>
                        <div class=" row justify-content-center custom_link_upload_cover" >
                            <a style="color: white" href="#" onclick="$('#cover').click();">Upload A Cover Picture</a></div>
                       <input id="cover" type="file" style="display: none" class="form-control{{ $errors->has('cover') ? ' is-invalid' : '' }}" name="cover" accept="image/*" >

                        @if ($errors->has('cover'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('cover') }}</strong>
                            </span>
                        @endif
                    
                </div>                
            </div>
        </div>
        <input type="hidden" name="routesPlan" id="routesPlan">
        </form>   

        @include('plans.maps_and_table')

    </div>  
@endsection

@section('myjsfile')
    <script src="https://maps.googleapis.com/maps/api/js?key={{$APP_KEY}}&libraries=places"></script>
    <script src="{{ asset('js/ContextMenu.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/declare_variables.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/insert_row_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/delete_row_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/initialize_map_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/insert_marker_before_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/insert_marker_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/remove_and_find_marker_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/delete_marker_on_table_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/redirect_and_display_function.js') }}" ></script>
    <script src="{{ asset('js/plans/maps/geocode_function.js') }}" ></script>
    <script src="{{asset('js/plans/add_datetime_picker_first_row.js')}}"></script>
    <script src="{{asset('js/plans/add_datetime_picker_time_plan.js')}}"></script>
    <script src="{{asset('js/plans/dropdown_menu_input.js')}}"></script>
    <script type="text/javascript">
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    <script src="{{asset('js/plans/preview_img.js')}}"></script>
    <script src="{{asset('js/plans/submit_form.js')}}"></script>
    <script src="{{asset('js/plans/edit/validate_form.js')}}"></script>
@endsection