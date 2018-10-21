<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travelling</title>

    
    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    {{-- jquery  --}}
    <script src="{{ asset('js/jquery-3.3.1.js') }}" ></script>
    {{-- Scripts --}}
    <script src="{{ asset('js/bootstrap.bundle.js') }}" ></script>
    
 
    {{-- Styles --}}
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- fontawsome --}}
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
    

    <link href="{{ asset('css/custums/mycss.css') }}" rel="stylesheet">
    <style>
        .no-js #loader { display: none;  }
        .js #loader { display: block; position: absolute; left: 100px; top: 0; }
        .se-pre-con {
          position: fixed;
          left: 0px;
          top: 0px;
          width: 100%;
          height: 100%;
          z-index: 9999;
          background: url( {{ asset('images/loader-64x/Preloader_1.gif') }} ) center no-repeat #fff;
        }
    </style>
    
    
    <script>
        //paste this code under head tag or in a seperate js file.
        // Wait for window load
       $(window).on('load', function() {
    // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
        $('body').css('background-image', 'url({{asset('/images/themes/bg.jpg')}})');
        });
    </script>


    <!-- this date time picker javascript -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.datetimepicker.css')}}" />
    
    <script src="{{ asset('js/build/jquery.datetimepicker.full.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}" ></script>
</head>
<body>
    <!-- loading -->
    <div class="se-pre-con"></div>
    @include('component.navbar')
    <br/>
    @if(Request::is('home')) 
        <div class="container-fluid">
            @include('component.carousel')
            <div class="row">
                <div class="col-md-8">
                    <div class="container">
                        @yield('content')    
                    </div>
                </div>
                <div class="col-md-4">
                    @include('component.sidebar')    
                </div>
            </div>
        </div>       
    @else
        @yield('content')    
    @endif
    
    @yield('myjsfile')

    @yield('mycssfile')
    
</body>
<br/>
<footer class="text-center" style="margin-bottom:0; padding: 20px; color:#fff; background:#333; width: 100%;">
    <p>Copyright 2018 &copy; Minh All rights reserved.</p>
</footer>
</html>
