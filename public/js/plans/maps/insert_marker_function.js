		/**
		 * To add a new marker
		 * @param  {Map} map      ,in which marker be set
		 * @param  {Object} location , location of marker
		 * @param  {Array} atCells  ,all cells id in which marker be display on table
		 * @param  {int} ind      ,position of marker in marker array
		 */
		function insertMarker(map, location, atCells, ind){
			var marker = new google.maps.Marker({
				position: location,
				draggable: true,
				map: map,
				atCells: atCells
			});

			//	Event dragend the marker
			google.maps.event.addListener(marker, "dragend", function(event) {
				// Change address display on table
				geocodeToAddress( event.latLng , marker.atCells );
				
				// If has more than two marker, direct the route
				if(markers.length>1){
					var route = prepareMarkers(markers);
					calculateAndDisplayRoute(directionsService, directionsDisplay, route);
				}
			});		
			
			// Event right click on marker, will display menu marker
			google.maps.event.addListener(marker,'rightclick', function(event){
				contextMenu.marker = this;
				displayMarkerMenu = true;
				google.maps.event.trigger(map, 'rightclick', event);
			});	

			markers.splice(ind,0,marker);	//	add marker to markers array
			
			// If has more than two marker, direct the route
			if(markers.length>1){
				var route = prepareMarkers(markers);
				calculateAndDisplayRoute(directionsService, directionsDisplay, route);
				endablePlan = 1;
				document.getElementById('endPlanButton').removeAttribute('disabled');
				//$('#endPlanButton').prop('disabled', false);
			}
		}