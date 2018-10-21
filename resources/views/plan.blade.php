@extends('layouts.app')

@section('content')
    
	<style>
    	#right-panel {
    		height: 600px;
    		float: right;
    		width: 390px;
    		overflow: auto;
  		}
  		#mapsearch{
  			margin-left: 25px;
  		}

  		/*	start styles for the ContextMenu	*/
		.context_menu{
			background-color:white;
			border:1px solid gray;
		}
		.context_menu_item{
			padding:3px 6px;
		}
		.context_menu_item:hover{
			background-color:#CCCCCC;
		}
		.context_menu_separator{
			background-color:gray;
			height:1px;
			margin:0;
			padding:0;
		}
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDoTL1bDXD9IrZcYEUzvbzeaeqWEgjtaro&libraries=places"></script>
	<script src="{{asset('js/ContextMenu.js')}}"></script>
	<script src="{{asset('js/insert_row.js')}}"></script>
	
	<div onload="initialise()">
		<div id="right-panel"></div>
		<div id="mapsearch" style=" width: 1100px; height: 500px"></div>	
	</div>	
	
	<br>		
	<table id="routes" class="table table-bordered">
		<thead class="table-dark">
			<tr>
				<th>Point Start</th>
				<th>Time Start</th>
				<th>Point End</th>
				<th>Time End</th>
				<th>Vehicle</th>
				<th>Activities</th>
				<th></th>
			</tr>	
		</thead>
		<tr>
			
			<td>
				<input id="start" class="form-control" type="text" name="start"></input>
			</td>
			<td></td>
			<td>
				<input id="finish" class="form-control" type="text" name="finish"></input>		
			</td>
			<td></td>
			<td><input type="text"></input></td>
			<td><input type="text"></input></td>
			<td><i id="addRow1" class="fa fa-plus" style="font-size: 40px; color: red" onclick="addRow(2)" name="addRow1"></i></td>
		</tr>
	</table>

	
    <script>
    	var directionsDisplay;
    	
    	var markers = [];
    	var waypoints = [];
    	var mapsearch;
    	var markerNow;

		
		
    	function myMap(){

    		mapsearch = new google.maps.Map(document.getElementById('mapsearch'),{
		  		zoom: 13,
		  		center: {lat: -33.8688, lng: 151.2195},
		  		mapTypeId: 'roadmap'
		  	});
		  	
		  	var start = document.getElementById('start');
		  	var finish = document.getElementById('finish');
		  	var searchStart = new google.maps.places.SearchBox(start);
		  	var searchFinish = new google.maps.places.SearchBox(finish);

		  	
		  	

		  	// bat su kien sau khi nhap xong
		  	searchFinish.addListener('places_changed', function(){
		  		

		  		geocodeAddress(start.value, mapsearch);
				geocodeAddress(finish.value, mapsearch);

		  		makeDirection( mapsearch, start.value , finish.value, waypoints);
		  	});


		  	// bat su kien sau click map
		  	google.maps.event.addListener(mapsearch,'click', function(event){
		  		
		  		
				waypoints.push( {location: event.latLng} );
				var mark = makeMarker(mapsearch, event.latLng);


				//	display the ContextMenu on a Map right click
				google.maps.event.addListener(mark, 'rightclick', function(mouseEvent){
					markerNow = mark;
					contextMenu.show(mouseEvent.latLng);
				});

				// reload map when drag
				mark.addListener('dragend', function(e){
					// position of waypoints smaller than markers 2 offset 
					var pos = markers.indexOf(mark);
        			waypoints[pos - 2] = { location: mark.position};
        			makeDirection( mapsearch, start.value , finish.value, waypoints);
        		})
				makeDirection( mapsearch, start.value , finish.value, waypoints);
		  	});

		  	
		  	//	create the ContextMenuOptions object
			var contextMenuOptions={};
			contextMenuOptions.classNames={menu:'context_menu', menuSeparator:'context_menu_separator'};
			
			//	create an array of ContextMenuItem objects
			var menuItems=[];
			menuItems.push({className:'context_menu_item', eventName:'zoom_in_click', label:'Zoom in'});
			menuItems.push({className:'context_menu_item', eventName:'zoom_out_click', label:'Zoom out'});
			//	a menuItem with no properties will be rendered as a separator
			menuItems.push({});
			menuItems.push({className:'context_menu_item', eventName:'center_map_click', label:'Center map here'});
			menuItems.push({className:'context_menu_item', eventName:'delete', label:'Delete marker'});
			contextMenuOptions.menuItems=menuItems;
			
			//	create the ContextMenu object
			var contextMenu = new ContextMenu(mapsearch, contextMenuOptions);
			
			
			//	listen for the ContextMenu 'menu_item_selected' event
			google.maps.event.addListener(contextMenu, 'menu_item_selected', function(latLng, eventName){
				//	latLng is the position of the ContextMenu
				//	eventName is the eventName defined for the clicked ContextMenuItem in the ContextMenuOptions
				switch(eventName){
					case 'zoom_in_click':
						mapsearch.setZoom(mapsearch.getZoom()+1);
						break;
					case 'zoom_out_click':
						mapsearch.setZoom(mapsearch.getZoom()-1);
						break;
					case 'center_map_click':
						mapsearch.panTo(latLng);
						break;
					case 'delete':

						// position of waypoints smaller than markers 2 offset 
						var pos = markers.indexOf(markerNow);
						console.log(pos);
						markerNow.setMap(null);
						// markers[pos].setMap(null);
						// console.log(markers[pos].position.toString());
						markers.splice(markerNow,1);
						
						// console.log(markers[pos].position.toString());
						waypoints.splice( (pos - 2) ,1);
        				
        				makeDirection( mapsearch, start.value , finish.value, waypoints);
						break;
				}
			});
		  	
    	}

    	// marker operation =================================================================
    	// ==================================================================================
    	function setMapOnAll(map) {
        	for (var i = 0; i < markers.length; i++) {
        		markers[i].setMap(map);
        	}
	    }
	    function clearMarkers() {
	        setMapOnAll(null);
      	}
      	function showMarkers(map) {
        	setMapOnAll(map);
      	}
      	function deleteMarkers() {
	    	clearMarkers();
        	markers = [];
    	}

    	// create marker and operation for map ==============================================
    	function makeMarker(map, address){
    		var marker = new google.maps.Marker({
        		map: map,
        		position: address,
        		draggable: true,
        	});
        	marker.addListener('click', function(){
        		console.log('aaaaaaaaaaaaaaaaaaaaaaaa');
        	})
    		markers.push(marker);
    		return marker;
    	}

    	// refresh map ========================================================================
    	// ====================================================================================
    	function refreshMap(){
    		clearMarkers();
    		if (directionsDisplay != null) {
    			directionsDisplay.setMap(null);
    			directionsDisplay.setPanel(null);
    			directionsDisplay = null;
			}
    	}


    	// return Location latLng
    	function geocodeAddress(addressString, map) {
    		var geocoder = new google.maps.Geocoder();
        	var address = addressString;
	        geocoder.geocode({'address': address},
	        	function(results, status) {
		        	if (status === 'OK') {
		        		makeMarker(map, results[0].geometry.location );
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}

    	function makeDirection(directionMap, start, end, waypoints){
    		// refresh map
    		refreshMap();

			directionsDisplay = new google.maps.DirectionsRenderer({
		  		map: directionMap,
		  		draggable: true,
		  		suppressMarkers: true
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
		  	}, function(response, status){
	        	if (status === 'OK') {
	        		
	        		showMarkers(mapsearch);
	        		directionsDisplay.setDirections(response);
	        	} else {
	        		window.alert('Directions request failed due to ' + status);
	        	}
	        })
		}


		// context menu ==============================================================================
		// ===========================================================================================
		// ===========================================================================================
		google.maps.event.addDomListener(window, 'load', myMap);
    </script>
    
@endsection

@section('sidebar')
    @parent
    <p>This is appended to the sidebar</p>

@endsection