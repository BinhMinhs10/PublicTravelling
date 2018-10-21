<html>
	<head>
		<title>Google Maps</title>

		<!-- Scripts bootstrap 4-->
	    <script src="{{ asset('js/bootstrap.js') }}" ></script>
	    <script src="{{ asset('js/bootstrap.min.js') }}" ></script>
	    <script src="{{ asset('js/bootstrap.bundle.js') }}" ></script>
	    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" ></script>
	    <!-- jquery  -->
	    <script src="{{ asset('js/jquery-3.3.1.js') }}" ></script>

	    

	    <!-- Styles -->
	    <link href="{{ asset('css/bootstrap-grid.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap-grid.min.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap-reboot.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap-reboot.min.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">


	    <!-- fontawsome -->
	    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet">
	    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
	    <style>
	    	#right-panel {
        		height: 600px;
        		float: right;
        		width: 390px;
        		overflow: auto;
      		}
	    </style>
	</head>
	<body>
		<h1>My First Google Map</h1>
		<div class="container">
			<div class="row align-content-center text-center">
				<div id="googleMap1" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
				<div id="googleMap2" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
				<div id="googleMap3" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
				<div id="map" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
		
			</div>
			<br/><br/>
			<div class="row">
				
				<div id="displaydata" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
				<div id="geolocation" style="width:450px;height:300px;"></div>&nbsp;&nbsp;
				
			</div>
			<br>
			<div class="row">
				<div class="col-md-6 form-group" id="locationField">
					<label for="start" >Điểm bắt đầu</label>
					<input id="start" class="form-control" type="text" name="start"></input>
				</div>
				<div class="col-md-6">
					<label for="finish">Điểm đến</label>
					<input id="finish" class="form-control" type="text" name="finish"></input>		
				</div>

			</div>
			<br/>
			
			<div id="mapsearch" style="width:700px;height:600px;"></div>
			<br>
			<div id="right-panel"></div>
			<div id="direction" style="width:700px;height:600px;"></div>
			
		</div>
		
		
		<script>

		var otherMarker;
		var polyline;
		var map1;
		var infoWindow;
		var maplocation;



		function myMap() {
			
			var mapOption1= {
			    center:{ lat: 41.879, lng: -87.624 },
			    zoom:7,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map1= new google.maps.Map(document.getElementById("googleMap1"),mapOption1);
			
			polyline = new google.maps.Polyline({
				strokeColor: "#0000FF",
				strokeOpacity: 0.8,
    			strokeWeight: 3,
    			editable: true,
    			draggable: true
    			
			});
			polyline.setMap(map1);
			map1.addListener('click',addLatLng);


			
			// map 3 ==================================================================================
			// ==================================================================================//
			// ==================================================================================//
			// ==================================================================================//
			
			var mapOption3= {
			    center:new google.maps.LatLng(51.508742,-0.120850),
			    zoom:9,
			    mapTypeId: google.maps.MapTypeId.HYBRID
			};
			
			var map3=new google.maps.Map(document.getElementById("googleMap3"),mapOption3);


			var myCenter = new google.maps.LatLng(51.508742,-0.120850);
			var anotherCenter = new google.maps.LatLng(51.500042,-0.350850);
			var marker = new google.maps.Marker({
				position:myCenter,
				animation: google.maps.Animation.BOUNCE
			});
			var anotherMarker = new google.maps.Marker({
				position:anotherCenter,
				title: "Travelling",
				animation: google.maps.Animation.BOUNCE
			});
			

			otherMarker = new google.maps.Marker({
				map: map3,
				draggable: true,
				animation: google.maps.Animation.DROP,
				position: {lat: 51.410042, lng: -0.200850}

			});
			otherMarker.addListener('click',toggleBounce);



			marker.setMap(map3);
			anotherMarker.setMap(map3);
			google.maps.event.addListener(anotherMarker,'click',function(){
				var contentString = '<div id="content">'+
			      '<div id="siteNotice">'+
			      '</div>'+
			      '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
			      '<div id="bodyContent">'+
			      '<p><b>Uluru</b>, <b>Ayers Rock</b>, is a large ' +
			      
			      
			      'Heritage Site.</p>'+
			      '<p>Attribution: Uluru, <a href="https://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
			      'https://en.wikipedia.org</a> '+
			      '(last visited June 22, 2009).</p>'+
			      '</div>'+
			      '</div>';
				var inforwindow = new google.maps.InfoWindow({	
				    content: contentString
				});
				inforwindow.open(map3,anotherMarker);
				
			});
			google.maps.event.addListener(marker,'click',function(){
				var pos = map3.getZoom();
				map3.setZoom(15);
				map3.setCenter(maker.getPosition());
				window.setTimeout(function() {map3.setZoom(pos);},3000);
			});

			// click to map and add marker to map
			google.maps.event.addListener(map3, 'click', function(event) {
    			placeMarker(map3, event.latLng);
  			});
			

			// map 2 ======================================================================//
			// ======================================================================//
			// ======================================================================//
			// ======================================================================//
			// ======================================================================//
			var stavanger = new google.maps.LatLng(58.983991,5.734863);
			var amsterdam = new google.maps.LatLng(52.395715,4.888916);
			var london = new google.maps.LatLng(51.508742,-0.120850);
			
			var mapOption2= {
			    center: new google.maps.LatLng(52.395715,4.888916),
			    zoom:4,
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map2=new google.maps.Map(document.getElementById("googleMap2"),mapOption2);

			var flightPath = new google.maps.Polygon({
			    path: [stavanger, amsterdam, london],
			    strokeColor: "#0000FF",
			    strokeOpacity: 0.8,
			    strokeWeight: 2,
			    fillColor: "#0000FF",
				fillOpacity: 0.4,
				editable: true,
			});
			flightPath.setMap(map2);

			// map 4 ===================================================================================
			//===================================================================================//
			//===================================================================================//
			//===================================================================================//
			

		  	var mapCanvas = document.getElementById("map");
		  	var mapOptions = {center: amsterdam, zoom: 7};
		  	var map = new google.maps.Map(mapCanvas,mapOptions);

		  	var myCity = new google.maps.Circle({
		    	center: amsterdam,
		    	radius: 50000,
		    	strokeColor: "#0000FF",
		    	strokeOpacity: 0.8,
		   		strokeWeight: 2,
		    	fillColor: "#0000FF",
		    	fillOpacity: 0.4,
		    	editable : true
		  	});
		  	myCity.setMap(map);


		  	// display data
		  	var mapOption = {
		  		zoom: 13,
		  		center: new google.maps.LatLng(51.5,-0.11)
		  	}
		  	var mapData = new google.maps.Map(document.getElementById('displaydata'),mapOption);
		  	var transitLayer = new google.maps.TransitLayer();
		  	transitLayer.setMap(mapData);


		  	

		  	// Geolocation ====================================================================
		  	//\=============================================================================
		  	// \=============================================================================
		  	// \===========================================================================
		  	
		  	maplocation = new google.maps.Map(document.getElementById('geolocation'),{
		  		center: {lat: -34.394, lng: 150.644},
		  		zoom: 15
		  	});
		  	infoWindow = new google.maps.InfoWindow;

		  	if(navigator.geolocation){
		  		navigator.geolocation.getCurrentPosition(function (position){
		  			var markerNow = new google.maps.Marker({
						map: maplocation,
						animation: google.maps.Animation.BOUNCE,
						position: {lat: position.coords.latitude, lng: position.coords.longitude}

					});
		  			var pos = {
		  				lat: position.coords.latitude,
		  				lng: position.coords.longitude,
		  			};
		  			infoWindow.setPosition(pos);
		  			infoWindow.setContent('Location found.');
		  			infoWindow.open(maplocation,markerNow);
		  			maplocation.setCenter(pos);	
		  		}, function() {
		  			handleLocationError(true, infoWindow, maplocation.getCenter());
		  		});
		  	}else{
		  		handleLocationError(false, infoWindow, maplocation.getCenter());
		  	}

		  	// Direction ============================================================================
		  	//======================================================================================
		  	//======================================================================================
		  	//======================================================================================

		  	var directionMap = new google.maps.Map(document.getElementById('direction'),{
		  		center: { lat: -34.394, lng: 150.644 },
		  		zoom: 15,

		  	});
		  	var start = "kingman, az";
		  	var end = "san bernardino, ca";
		  	var waypoints = [{location: 'County Rte 66'}];
		  	makeDirection(directionMap, start, end, waypoints);
		  	


		  	// maps search +-+-+====================================================================//
		  	// ============================================================================//
		  	// ============================================================================//
		  	// ============================================================================//
		  	var mapsearch = new google.maps.Map(document.getElementById('mapsearch'),{
		  		zoom: 13,
		  		center: {lat: -33.8688, lng: 151.2195},
		  		mapTypeId: 'roadmap'
		  	});
		  	
		  	var start = document.getElementById('start');
		  	var finish = document.getElementById('finish');
		  	var searchStart = new google.maps.places.SearchBox(start);
		  	var searchFinish = new google.maps.places.SearchBox(finish);
		  	
		  	mapsearch.addListener('bounds_changed', function() {
          		searchStart.setBounds(mapsearch.getBounds());
    		});

		  	var markers = [];
		  	var waypoints = [];
		  	
		  	searchStart.addListener('places_changed', function(){
		  		var places = searchStart.getPlaces();
		  		
		  		if(places.length == 0){
		  			return;
		  		}
		  		markers.forEach(function(marker){
		  			marker.setMap(null);
		  		});
		  		markers = [];
		  		var bounds = new google.maps.LatLngBounds();
		  		places.forEach(function(place) {
		            if (!place.geometry) {
		            	console.log("Returned place contains no geometry");
		            	return;
		            }
		            // Create a marker for each place.
		            markers.push(new google.maps.Marker({
		            	map: mapsearch,
		            	title: place.name,
		            	position: place.geometry.location,
		            	draggable: true,
		            }));

		            if (place.geometry.viewport) {
		            	// Only geocodes have viewport.
		            	bounds.union(place.geometry.viewport);
		            } else {
		            	bounds.extend(place.geometry.location);
		            }
		        });
		        mapsearch.fitBounds(bounds);
		  	});
		}


		//===============================================================================//
		//===============================================================================//
		//===============================================================================//
		//===============================================================================//
		function makeDirection( directionMap, start, end, waypoints){
			var directionsDisplay = new google.maps.DirectionsRenderer({
		  		map: directionMap,
		  		draggable: true,
		  	});
		  	var directionsService = new google.maps.DirectionsService;	
		  	directionsDisplay.setPanel(document.getElementById('right-panel'));
		  	
		  	directionsService.route({
		  		origin: start,
		  		destination: end,
		  		waypoints: waypoints,
		  		travelMode: 'DRIVING',
		  		provideRouteAlternatives: true, 
		  		avoidTolls: true,
		  	}, function(response, status) {
	        	if (status === 'OK') {
	        		directionsDisplay.setDirections(response);
	        	} else {
	        		window.alert('Directions request failed due to ' + status);
	        	}
	        })
		}

		function handleLocationError(browserHasGeoLocation, infoWindow, pos) {
	  		infoWindow.setPosition(pos);
	  		infoWindow.setContent(browserHasGeoLocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    		infoWindow.open(maplocation);
	  	}
		function addLatLng(event){
			
			var path = polyline.getPath();
			path.push(event.latLng);
			var marker = new google.maps.Marker({
				position: event.latLng,
				title: '#'+path.getLength(),
				map: map1,
				editable: true,
    			draggable: true,
			});
		}
		function placeMarker(map, location) {
			var marker = new google.maps.Marker({
				position: location,
				map: map
			});
			var infowindow = new google.maps.InfoWindow({
				content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
			});
			infowindow.open(map,marker);
		}
		function toggleBounce() {
  			if (otherMarker.getAnimation() !== null) {
   		 		otherMarker.setAnimation(null);
	  		} else {
	    		otherMarker.setAnimation(google.maps.Animation.BOUNCE);
	  		}
	  	}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoTL1bDXD9IrZcYEUzvbzeaeqWEgjtaro&libraries=places&callback=myMap"></script>
	</body>
</html>