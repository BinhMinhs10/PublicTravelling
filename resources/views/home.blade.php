@extends('layouts.app')

@section('content')


<div class="input-group mb-3">
	<div class="input-group-prepend">
		<span class="input-group-text" id="inputGroup-sizing-default">Search</span>
		</div>
		<input id="search" name="search" type="text" class="form-control" aria-label="Search" aria-describedby="inputGroup-sizing-default">
	</div>
	<div id="seachResult" class="row">
		
	</div>

<h1>Hot Plans</h1>
<hr>
<div id="demo" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#demo" data-slide-to="0" class="active"></li>
		<li data-target="#demo" data-slide-to="1"></li>
		<li data-target="#demo" data-slide-to="2"></li>
		<li data-target="#demo" data-slide-to="3"></li>
		<li data-target="#demo" data-slide-to="4"></li>
		<li data-target="#demo" data-slide-to="5"></li>
		<li data-target="#demo" data-slide-to="6"></li>
		<li data-target="#demo" data-slide-to="7"></li>
		<li data-target="#demo" data-slide-to="8"></li>
		<li data-target="#demo" data-slide-to="9"></li>
	</ul>
	<div class="carousel-inner">
	@for($i=0 ; $i < count($hotPlans) ; $i++)
		<div class="carousel-item @if($i==0) active @endif">
			<a href="{{ url('plans/'. $hotPlans[$i]->id )}}" >
				<img src="{{ asset('images/plans/'. $hotPlans[$i]->cover) }}" width="100%" height="480" class="bod15">
				<div class="carousel-caption row text-left bod15 car-cap-fix-custm">
					<div class="col-md-12">
						<h3>{{ $hotPlans[$i]->title }}</h3>
						<i class="fa fa-toggle-on"> {{ $hotPlans[$i]->start_at }}</i><br>
						<i class="fa fa-toggle-off"> {{ $hotPlans[$i]->end_at }}</i><br>
						<i class="fa fa-group"> {{ $hotPlans[$i]->num_join +1}}/{{ $hotPlans[$i]->member}} </i>
						<i class="fa fa-feed marleft15"> {{ $hotPlans[$i]->num_follow }} </i>
						<i class="fa fa-comments-o marleft15"> {{ $hotPlans[$i]->num_comment }}</i><br>
						@if ($hotPlans[$i]->state===1)
                        <i class="fa fa-ellipsis-h"> Planning</i>
                        @elseif ($hotPlans[$i]->state===2)
                        <i class="fa fa-cogs"> Running</i>
                        @elseif ($hotPlans[$i]->state===3)
                        <i class="fa fa-check-circle-o"> Ended</i>
                        @elseif ($hotPlans[$i]->state===4)
                        <i class="fa fa-warning"> Cancled</i>
                        @endif
					</div>
					
				</div>  
			</a> 
		</div>
	@endfor
	</div>
	<a class="carousel-control-prev" href="#demo" data-slide="prev">
		<span class="carousel-control-prev-icon"></span>
	</a>
	<a class="carousel-control-next" href="#demo" data-slide="next">
		<span class="carousel-control-next-icon"></span>
	</a>
</div>

<div class="row martop80"></div>
<h1>New Plans</h1>
<hr>
<div class=row>
	@foreach( $newPlans as $plan)
		<div class="col-md-6">
			<a href="plans/{{ $plan->id }}" class="custm-fix-link">
				<div class="card bod15 custm-fix-card">
			  		<img class="card-img-top bod15 img-card" src="{{ asset('images/plans/'. $plan->cover) }}" alt="Card image cap">
			  		
			  		<div class="row card-body">
			  			<h5 class="card-title"> {{ $plan->title }}</h5>
			  			<div class="col-md-12">
							<i class="fa fa-toggle-on"> {{ $plan->start_at }}</i>
							<i class="fa fa-group marleft45"> {{ $plan->num_join +1}}/{{ $plan->member}}</i>
				    		<i class="fa fa-feed marleft15"> {{ $plan->num_follow }}</i>
							<i class="fa fa-comments-o marleft15"> {{ $plan->num_comment }}</i><br>
							<i class="fa fa-toggle-off"> {{ $plan->end_at }}</i>
							@if ($plan->state===1)
                            <i class="fa fa-ellipsis-h marleft45"> Planning</i>
                            @elseif ($plan->state===2)
                            <i class="fa fa-cogs marleft45"> Running</i>
                            @elseif ($plan->state===3)
                            <i class="fa fa-check-circle-o marleft45"> Ended</i>
                            @elseif ($plan->state===4)
                            <i class="fa fa-warning marleft45"> Cancled</i>
                            @endif
			  			</div>
			  			
			  		</div>
				</div>
			</a>
		</div>
	@endforeach
	
</div>

<script type="text/javascript">
	$('#search').keyup( function(){
		$value = $(this).val();
		$.ajax({
			type : 'get',
			url : '{{URL::to("search")}}',
			data:{'search': $value},
			success:function(data){
				$('#seachResult').html(data);
			}
		});
	});

</script>
@endsection

@section('mycssfile')
     <link href="{{ asset('css/custums/home.css') }}" rel="stylesheet">
@endsection



