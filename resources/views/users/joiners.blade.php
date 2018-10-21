@extends('layouts.app')

@section('content')
	<table class="table table-hover table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th></th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        @foreach( $plan->followers as $follower)
            @if( $follower->pivot->isRequest == 1)
                <tr id="{{ $follower->id }}">
                    <td><img src="{{ asset($follower->avatar) }}" alt="Avatar" style="width: 150px; height: 150px;"></td>
                    <td>{{ $follower->fullname }}</td>
                    <td>{{ $follower->email }}</td>
                    <td>
                        <button id="deny{{ $follower->id }}" user_id="{{ $follower->id }}" plan_id="{{ $plan->id }}" class="btn btn-danger" onclick="deny(this)"><i class="fa fa-user-times" style="font-size:24px"></i></button>
                        &nbsp;&nbsp;
                        <button id="accept{{ $follower->id }}" user_id="{{ $follower->id }}" plan_id="{{ $plan->id }}" class="btn btn-warning" onclick="accept(this)"><i class="fa fa-user-plus" style="font-size:24px"></i></button>
                        &nbsp;&nbsp;
                        <a href="{{ url('users/'. $follower->id) }}" class="btn btn-primary">Detail</a>
                    </td>

                </tr>
            @elseif( $follower->pivot->isRequest == 2)
				<tr id="{{ $follower->id }}">
                    <td><img src="{{ asset($follower->avatar) }}" alt="Avatar" style="width: 150px; height: 150px;"></td>
                    <td>{{ $follower->fullname }}</td>
                    <td>{{ $follower->email }}</td>
                    <td>
                        <button id="deny{{ $follower->id }}" user_id="{{ $follower->id }}" plan_id="{{ $plan->id }}" class="btn btn-danger" onclick="deny(this)"><i class="fa fa-user-times" style="font-size:24px"></i></button>
                        &nbsp;&nbsp;
                        <a href="{{ url('users/'. $follower->id) }}" class="btn btn-primary">Detail</a>
                    </td>
                </tr>
            @endif
        @endforeach
    </table>

@endsection

@section('mycssfile')
     <link href="{{ asset('css/custums/home.css') }}" rel="stylesheet">
@endsection
<script>  
    function deny(el){
        var user_id = el.getAttribute('user_id');
        var plan_id = el.getAttribute('plan_id');
        var data = {
            _token: "{{ csrf_token() }}",
            user_id: user_id,
            plan_id: plan_id
        };
        alert("waiting few minute!");
        $(document).ready(function(){
            $.ajax({
                url: "{{ url('deny') }}",
                method: 'post',
                async: true,
                data: data,
                success: function(result) {
                    $(el).parent().parent().remove();
                },
                error: function() {
                    alert('Sorry have error , please load again this page');
                },
            });
            
        });
    }
    function accept(el){
        var user_id = el.getAttribute('user_id');
        var plan_id = el.getAttribute('plan_id');
        var data = {
            _token: "{{ csrf_token() }}",
            user_id: user_id,
            plan_id: plan_id
        };
        alert("waiting few minute!");
        $(document).ready(function(){
            $.ajax({
                url: "{{ url('accept') }}",
                method: 'post',
                async: true,
                data: data,
                success: function(result) {
                    if(result == 1){
                        console.log(result);
                        $(el).remove();    
                    }else{
                        alert('Full menber for this plan!');
                    }
                    
                },
                error: function() {
                    alert('Sorry have error , please load again this page');
                },
            });
            
        });
    }
</script>