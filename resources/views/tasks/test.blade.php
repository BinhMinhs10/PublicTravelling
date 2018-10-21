<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
	<meta charset="UTF-8">
	<title>Google Map Search</title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<style type="text/css">
		#map{
			height: 50%;
		}
		html,body{
			height: 100%;
			margin: 0;
			padding: 0;
		}
		/*  start styles for the ContextMenu  */
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
		#endPlan, #deleteMarker, #insertBefore, #insertAfter{
			display:none;
		}
		/*  end styles for the ContextMenu  */		
	</style>
</head>
<body>
	
	<div id="right-panel"></div>
	<div id="map" style=" width: 1100px; height: 500px"></div>
	<br>		
	<table id="routes" class="table table-bordered">
		<thead class="table-dark">
			<tr>
				<th>Marker Start</th>
				<th>Time Start</th>
				<th>Marker End</th>
				<th>Time End</th>
				<th>Vehicle</th>
				<th>Activities</th>
				<th></th>
			</tr>	
		</thead>
		<tr>
			<td>
				<input id="start1" lass="form-control" type="text" name="start1" autocomplete="off"></input>
			</td>
			<td>
				<input id="timeStart1" class="form-control" type="datetime-local" name="timeStart1" autocomplete="off"></input>
			</td>
			<td>
				<input id="finis1" class="form-control" type="text" name="finis1" autocomplete="off"></input>		
			</td>
			<td>
				<input id="timeEnd1" class="form-control" type="datetime-local" name="timeEnd1" autocomplete="off"></input>
			</td>
			<td><input id="vehicle1" type="text" name="vehicle1" autocomplete="off"></input></td>
			<td><input id="activities1" type="text" name="activities1" autocomplete="off"></input></td>
			<td><i id="addRow1" class="fa fa-plus" style="font-size: 40px; color: red" onclick="addRow(this)" name="addRow1"></i></td>
			<td><i id="delRow1" class="fa fa-minus" style="font-size: 40px; color: red" onclick="delRow(this)" name="delRow1"></i></td>

		</tr>
	</table>	
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBP-JN55aLbE2fiOC1SaA7tdP89ll8p7Tw&libraries=places"></script>
	<script type="text/javascript" src="{{ asset('js/ContextMenu.js') }}"></script>
	<script type="text/javascript">
		var map;
		var directionsService;
		var directionsDisplay;
		var endablePlan = 1;
		var markers = [];
		var displayMarkerMenu = false;
		var geocoder = new google.maps.Geocoder();
		var orders = [1];
		var currentIndex = 1; //the max index of row element id
		var indexMarker;
		var myLatLng;

		function addRow(cell){
	        var myTable = document.getElementById("routes");
	        var clickedRowIndex = cell.parentNode.parentNode.rowIndex;	//	index of row which click on it
			var finish = document.getElementById('finis'+orders[clickedRowIndex-1]);	// cause orders=[1,...]
			var start = document.getElementById('start'+orders[clickedRowIndex-1]);
			if(start.value ===''){
	        	alert('Please complete this route before adding new route!');
	        }else{
	        	if(finish.value ===''){
	        		add(clickedRowIndex, 'start');
	        	}else{
	        		add(clickedRowIndex, 'finis');
	        	}
	        }

		}
        function add(index, mode){
        	var myTable = document.getElementById("routes");
        	var newRowIndex = ++currentIndex;	//	index of elements in row which will be added
	        var newRow = myTable.insertRow(index+1);	//	insert a row after the row has just been clicked on

	        orders.splice(index,0,newRowIndex);	//	insert index of elements in new row to order array

	        var startBox = document.createElement("input");
	        startBox.setAttribute("name", "start" + newRowIndex);
	        startBox.setAttribute("id", "start" + newRowIndex);

	        var previousRowIndex = orders[index-1];
	        
	        startBox.setAttribute("value", document.getElementById(mode+previousRowIndex).value);
	        var marker = markers[markers.length-1];
	        var atCells = marker.atCells;
	        atCells.push("start" + newRowIndex);
	        marker.atCells = atCells;

	        var timeStartBox = document.createElement("input");
	        timeStartBox.setAttribute("name", "timeStart" + newRowIndex);
	        timeStartBox.setAttribute("id", "timeStart" + newRowIndex);
	        timeStartBox.setAttribute("type", "datetime-local");

	        var finishBox = document.createElement("input");
	        finishBox.setAttribute("name", "finis" + newRowIndex);
	        finishBox.setAttribute("id", "finis" + newRowIndex);

	        var timeEndBox = document.createElement("input");
	        timeEndBox.setAttribute("name", "timeEnd" + newRowIndex);
	        timeEndBox.setAttribute("id", "timeEnd" + newRowIndex);
	        timeEndBox.setAttribute("type", "datetime-local");	        

	        var vehicleBox = document.createElement("input");
	        vehicleBox.setAttribute("name", "vehicle" + newRowIndex);
	        vehicleBox.setAttribute("id", "vehicle" + newRowIndex);

	        var activitiesBox = document.createElement("input");
	        activitiesBox.setAttribute("name", "activities" + newRowIndex);
	        activitiesBox.setAttribute("id", "activities" + newRowIndex);

	        var addRowBox = document.createElement("i");
	        addRowBox.setAttribute("id", "addRow" + newRowIndex);
	        addRowBox.setAttribute("name", "addRow" + newRowIndex);
	        addRowBox.setAttribute("style","font-size: 40px; color: red");
	        addRowBox.setAttribute("onclick", "addRow(this)");
	        addRowBox.setAttribute("class","fa fa-plus");

	        var delRowBox = document.createElement("i");
	        delRowBox.setAttribute("id", "delRow" + newRowIndex);
	        delRowBox.setAttribute("name", "delRow" + newRowIndex);
	        delRowBox.setAttribute("style","font-size: 40px; color: red");
	        delRowBox.setAttribute("onclick", "delRow(this)");
	        delRowBox.setAttribute("class","fa fa-minus");	        

	        var currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(startBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(timeStartBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(finishBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(timeEndBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(vehicleBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(activitiesBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(addRowBox);

	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(delRowBox);

	        
		  	var searchStart = new google.maps.places.SearchBox(startBox);
		  	var searchFinish = new google.maps.places.SearchBox(finishBox);
		  	
		  	// Bắt sự kiện khi nhập xong finish
		  	searchFinish.addListener('places_changed', function(){
		  		
				getMarker(startBox.value);
				
				// index là id của dòng đang tạo
				geocodeAddress(startBox.value, newRowIndex);
				//addRow(addRowBox);
		  	});
        }	

        function delRow(cell){
	        var myTable = document.getElementById("routes");
	        var clickedRowIndex = cell.parentNode.parentNode.rowIndex;	//	index of row which click on it, click row 1, return 1
			var finish = document.getElementById('finis'+orders[clickedRowIndex-1]);	// cause orders=[1,...]
			var start = document.getElementById('start'+orders[clickedRowIndex-1]);
        	
	 		
	  		if(clickedRowIndex===1 && myTable.rows.length===2){
	  			alert("You can not delete this row!");
	  		}
	        else{
	        	var markerFinishIndex = findMarker(finish.id);
	        	var markerStartIndex = findMarker(start.id);
	        	var atCellsStart = markers[markerStartIndex].atCells;
	        	myTable.deleteRow(clickedRowIndex);	//	delete row
		        orders.splice(clickedRowIndex-1,1);	//	delete order in orders array
	        	//	If route only has marker start, delete row and update atCells attribute of the marker start       	
		        if(finish.value ===''){
		        	var k = atCellsStart.indexOf(start.id);
				    atCellsStart.splice(k,1); //	should check k!=-1
				    markers[markerStartIndex].atCells = atCellsStart;
				//	If route has marker start and marker finish
		        }else{
		        	var atCellsFinish = markers[markerFinishIndex].atCells;
	        		var k = atCellsStart.indexOf(start.id);
	        		var m = atCellsFinish.indexOf(finish.id);
		        	atCellsStart.splice(k,1);
		        	atCellsFinish.splice(m,1);
		        	atCellsFinish = atCellsStart.concat(atCellsFinish);	//	merge 2 array
		        	markers[markerFinishIndex].atCells = atCellsFinish;
		        	removeMarker(markers[markerStartIndex]);
		        	for (var i = 0; i < atCellsFinish.length - 1; i++) {
		        		document.getElementById(atCellsFinish[i]).value = 
		        		document.getElementById(atCellsFinish[atCellsFinish.length-1]).value;
		        	}	        	
		        }
	        }                	
        }			

		function initMap(){
			var mapOptions={
				zoom: 12,
				center: new google.maps.LatLng(21.017217, 105.783722),
				mapTypeId: 'roadmap'
			};

			map = new google.maps.Map(document.getElementById('map'), mapOptions);

			directionsService = new google.maps.DirectionsService;
			directionsDisplay = new google.maps.DirectionsRenderer({
				draggable: true,
				suppressMarkers: true
			});
			directionsDisplay.setMap(map);

			var start = document.getElementById('start1');
		  	var finish = document.getElementById('finis1');
		  	var addRow1 = document.getElementById('addRow1');
		  	var searchStart = new google.maps.places.SearchBox(start);
		  	var searchFinish = new google.maps.places.SearchBox(finish);

		  	searchStart.addListener('places_changed', function(){
		  		if(markers.length>0) {
		  			removeMarker(markers[0]);
		  		}
		  		var address = start.value;
		  		start.value = '';
		  		geocodeAddress(address);
		  	});

		  	// Event of finish entering SearchFinish box
		  	searchFinish.addListener('places_changed', function(){
		  		if(markers.length>1) {
		  			removeMarker(markers[1]);
		  		}
		  		var address = finish.value;
		  		finish.value = '';
		  		geocodeAddress(address);
		  	});			
			

			google.maps.event.addListener(map,'click', function(event) {
				if(contextMenu.isVisible_ == true){
					contextMenu.hide();
				}else{
					var myTable = document.getElementById('routes');
					var currentRow = orders[orders.length-1];
					var finish = document.getElementById('finis'+currentRow);
					var start = document.getElementById('start'+currentRow);

					if(finish.value !== ''){
						if(start.value !== ''){
							addRow(document.getElementById('addRow'+currentRow));
							geocodeToAddress(event.latLng,['finis'+(currentRow+1)]);
							insertMarker(map,event.latLng, ['finis'+(currentRow+1)], markers.length);
						}
						else{
							//only for first row
							geocodeToAddress(event.latLng,['start'+currentRow]);
							insertMarker(map,event.latLng, ['start'+ currentRow], 0);
						}
						
					}else{
						if(start.value !== ''){
							geocodeToAddress(event.latLng,['finis'+currentRow]);
							insertMarker(map,event.latLng, ['finis'+currentRow], markers.length);
						}else{
							geocodeToAddress(event.latLng,['start'+currentRow]);
							insertMarker(map,event.latLng, ['start'+ currentRow], markers.length);
						}
					}
				}
					
			});


			//  create the ContextMenuOptions object
			var contextMenuOptions={};
			contextMenuOptions.classNames={menu:'context_menu', menuSeparator:'context_menu_separator'};

			//  create an array of ContextMenuItem objects
			var menuItems=[];
			menuItems.push({className:'context_menu_item', eventName:'delete_marker', label:'Delete marker', id:'deleteMarker'});
			menuItems.push({className:'context_menu_item', eventName:'insert_before', label:'Insert before', id:'insertBefore'});
			menuItems.push({className:'context_menu_item', eventName:'insert_after', label:'Insert after', id:'insertAfter'});
			menuItems.push({className:'context_menu_item', eventName:'end_plan', label:'End plan', id:'endPlan'});
			menuItems.push({});
			menuItems.push({className:'context_menu_item', eventName:'zoom_in_click', label:'Zoom in'});
			menuItems.push({className:'context_menu_item', eventName:'zoom_out_click', label:'Zoom out'});
			//  a menuItem with no properties will be rendered as a separator
			menuItems.push({});
			menuItems.push({className:'context_menu_item', eventName:'center_map_click', label:'Center map here'});
			menuItems.push({className:'context_menu_item', eventName:'close_menu', label:'Close menu'});
			contextMenuOptions.menuItems=menuItems;

			//  create the ContextMenu object
			contextMenu=new ContextMenu(map, contextMenuOptions);

			//  display the ContextMenu on a Map right click
			google.maps.event.addListener(map, 'rightclick', function(mouseEvent){
			    document.getElementById('endPlan').style.display=(markers.length>=2 && endablePlan === 1 && ((!displayMarkerMenu)||(displayMarkerMenu&&markers.indexOf(contextMenu.marker)=== (markers.length-1))))?'block':'none';
		    	document.getElementById('deleteMarker').style.display= displayMarkerMenu ?'block':'none';
		    	document.getElementById('insertAfter').style.display= (displayMarkerMenu && (markers.indexOf(contextMenu.marker)!== (markers.length-1)) )?'block':'none';
		    	document.getElementById('insertBefore').style.display= (displayMarkerMenu && (markers.indexOf(contextMenu.marker)!==0) ) ?'block':'none';
		    	displayMarkerMenu = false;		
				contextMenu.show(mouseEvent.latLng);
			});


			//  listen for the ContextMenu 'menu_item_selected' event
			google.maps.event.addListener(contextMenu, 'menu_item_selected', function(latLng, eventName){
				//  latLng is the position of the ContextMenu
				//  eventName is the eventName defined for the clicked ContextMenuItem in the ContextMenuOptions
				switch(eventName){
					case 'delete_marker':
						contextMenu.hide();
						deleteMarkerOnTable(contextMenu.marker);
						endablePlan =1;
						break;	
					case 'insert_before':
						contextMenu.hide();
						insertBefore(contextMenu.marker);
						break;
					case 'insert_after':
						contextMenu.hide();
						var nextMarkerIndex = markers.indexOf(contextMenu.marker) + 1 ;
						insertBefore(markers[nextMarkerIndex]);
						break;																
					case 'end_plan':
						contextMenu.hide();
						endablePlan = 0; //mark that plan is end, this menu never display again if having no change with marker
						document.getElementById('endPlan').style.display='none';
						
						var myTable = document.getElementById('routes');
						var finish = document.getElementById('finis'+(myTable.rows.length-1));
						var start = document.getElementById('start'+(myTable.rows.length-1));						
						addRow(myTable.rows.length);
						document.getElementById('start'+(myTable.rows.length-1)).value= (finish.value==='')?start.value:finish.value;
						document.getElementById('finis'+(myTable.rows.length-1)).value=document.getElementById('start1').value;

						var route = markers.concat([markers[0]]);
						route = prepareMarkers(route);
						calculateAndDisplayRoute(directionsService, directionsDisplay, route);
						break;
					case 'zoom_in_click':
						contextMenu.hide();
						map.setZoom(map.getZoom()+1);
						break;
					case 'zoom_out_click':
						contextMenu.hide();
						map.setZoom(map.getZoom()-1);
						break;
					case 'center_map_click':
						contextMenu.hide();
						map.panTo(latLng);
						break;
					case 'close_menu':
						contextMenu.hide();
						break;
				}
			});
		}

		function insertBefore(marker){
			ind = markers.indexOf(marker);
			var lat1 = markers[ind - 1].position.lat();
			var lat2 = markers[ind].position.lat();
			var lng1 = markers[ind - 1].position.lng();
			var lng2 = markers[ind].position.lng();
			latLng = {
				lat: (lat1+lat2)/2,
				lng: (lng1+lng2)/2
			};
			var oldAtCells = marker.atCells;
			var newAtCells =[];
			var firstOldCell = oldAtCells[0];
			var indexOfFirstOldCell = parseInt(firstOldCell.slice(5,firstOldCell.length));
			addRow(document.getElementById('addRow'+indexOfFirstOldCell));
			var newRowIndex = currentIndex;
			//var newIndex = orders.indexOf(newRowIndex);
			document.getElementById('finis'+newRowIndex).value= document.getElementById(oldAtCells[0]).value;
			newAtCells.unshift(oldAtCells.shift());
			newAtCells.push('start'+newRowIndex);
			oldAtCells.unshift('finis'+newRowIndex);
			marker.atCells = oldAtCells;
			geocodeToAddress(latLng, newAtCells);
			insertMarker(map, latLng, newAtCells, ind);
		}


		function insertMarker(map, location, atCells, ind){
			var marker = new google.maps.Marker({
				position: location,
				draggable: true,
				map: map,
				atCells: atCells
			});
			google.maps.event.addListener(marker, "dragend", function(event) {
				geocodeToAddress( event.latLng , marker.atCells );
				if(markers.length>1){
					var route = prepareMarkers(markers);
					calculateAndDisplayRoute(directionsService, directionsDisplay, route);
					endablePlan = 1;
				}
			});
			
			google.maps.event.addListener(marker,'rightclick', function(event){
				contextMenu.marker = this;
				displayMarkerMenu = true;
				google.maps.event.trigger(map, 'rightclick', event);
			});	

			markers.splice(ind,0,marker);
			
			if(markers.length>1){
				var route = prepareMarkers(markers);
				calculateAndDisplayRoute(directionsService, directionsDisplay, route);
			}
		}


		function removeMarker(marker){
			var ind = markers.indexOf(marker);
			marker.setMap(null);
			markers.splice(ind,1);
			if(markers.length>1){
				var route = prepareMarkers(markers);
				calculateAndDisplayRoute(directionsService, directionsDisplay, route);
			}else{
				directionsDisplay.setMap(null);
				directionsDisplay = new google.maps.DirectionsRenderer({
					draggable: true,
					suppressMarkers: true
				});
				directionsDisplay.setMap(map);							
			}
		}


		/**
		 * To find which marker on a cell of table
		 * @param  String  ,elementId ex: start1, finis2,..
		 * @return int  i ,index of the marker which has atCells include elementId
		 */
		function findMarker(elementId){
			for (var i = markers.length - 1; i >= 0; i--) {
				if(markers[i].atCells.includes(elementId)){
					return i;
				}
			}
		}

		function deleteMarkerOnTable(marker){
			var atCells = marker.atCells;

			if(markers.length>2){
				if(markers.indexOf(marker) === (markers.length-1)){
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
					}
					removeMarker(marker);
				}
				else{
					var lastInd= 0;
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
						if (atCells[i].slice(0,5) === 'start'){
							var ind = parseInt(atCells[i].slice(5,atCells[0].length));
							ind = orders.indexOf(ind);
							last = (lastInd > ind)? lastInd : ind;
						}
					}
					delRow(document.getElementById('delRow'+orders[lastInd]));
				}
			}else{
				if(markers.indexOf(marker)===0 && markers.length===2){
					var startAtCells = marker.atCells;
					var finishAtCells = markers[1].atCells;
					
					document.getElementById(startAtCells[0]).value = document.getElementById(markers[1].atCells[0]).value;
					document.getElementById(markers[1].atCells[0]).value = '';
					finishAtCells.shift();
					startAtCells = startAtCells.concat(finishAtCells);
					markers[1].atCells = startAtCells;
					for (var i = markers[1].atCells.length - 1; i > 0; i--) {
						document.getElementById(markers[1].atCells[i]).value = 
						document.getElementById(markers[1].atCells[0]).value;
					}

					removeMarker(marker);
				}else{
					removeMarker(marker);
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
					}	
				}				 
			}
		}

		function calculateAndDisplayRoute(directionsService, directionsDisplay, route){
			directionsService.route({
				origin: route.origin,
				destination: route.destination,
				waypoints: route.waypoints,
				travelMode: 'DRIVING'
			}, function(response, status){
				if (status === 'OK') {
					directionsDisplay.setDirections(response);
				}else{
					window.alert('Directions request failed due to ' + status);
				}
			});
		}


		// tranform markers to waypoint , start, finish
		function prepareMarkers(markers){
			var inways = markers.slice(1, markers.length - 1);
			var waypoints=[];
			for (var i =0; i<inways.length;i++){
				waypoints.push({location: inways[i].position});
			}	
			var route={
				origin: {location: markers[0].position},
				destination: {location: markers[markers.length-1].position},
				waypoints: waypoints
			}
			return route;	
		}

		/**
		 * Return location latLng from String address
		 * @param  {[type]} addressString [description]
		 * @param  {[type]} map           [description]
		 * @param  {[type]} atCells       [description]
		 * @param  {[type]} ind           [description]
		 * @return {[type]}               [description]
		 */
    	function geocodeAddress(addressString) {
	        geocoder.geocode({'address': addressString},
	        	function(results, status) {
		        	if (status === 'OK') {
		        		myLatLng = results[0].geometry.location;
		        		var event={
		        			latLng: myLatLng
		        		};
		  				google.maps.event.trigger(map, 'click', event);
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}

      			//	Return location latLng from String address
   //  	function geocodeAddress(finishAddress, id) {


   //  		//  pos+1: vị trí của phần tử đó trong bảng
			// var pos = orders.indexOf(id);

			// //	index : vị trí của marker trong mảng markers
			// console.log("vi tri cua marker muon them "+indexMarker);

	  //       geocoder.geocode({'address': finishAddress},
	  //       	function(results, status) {
		 //        	if (status === 'OK') {
		 //        		if(id == -1){
		 //        			insertMarker(map, results[0].geometry.location, 
		 //        			[], 0);
		 //        		}else{
		 //        			insertMarker(map, results[0].geometry.location, 
		 //        			[ ['finish'+orders[pos-1]],['start'+id ]], indexMarker);	
		 //        		}
		        		
		 //        	} else {
		 //            	alert('Geocode was not successful for the following reason: ' + status);
		 //          	}
	  //       });
   //    	}


      	function getMarker(address){
      		geocoder.geocode({'address': address},
	        	function(results, status) {
		        	if (status === 'OK') {
		        		for(var i=0; i<markers.length; i++){
		        			if(markers[i].position.toString() == results[0].geometry.location.toString()){
		        				indexMarker = i;
		        				console.log("indexMarker phần tử thứ bên trong "+ indexMarker);
		        				break;		
		        			}
		        		}
		        		 
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}

		//	Return String address from location latLong
    	function geocodeToAddress(location, elementIds ) {
	        geocoder.geocode({'location': location}, function(results, status) {
		        	if (status === 'OK') {
		        		for (var i = elementIds.length - 1; i >= 0; i--) {
		        			if(document.getElementById(elementIds[i])!=null){
		        				document.getElementById(elementIds[i]).value = results[0].formatted_address;
		        			}
		        		}
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}      	


		google.maps.event.addDomListener(window, 'load', initMap);
	</script>
	
	
</body>
</html>