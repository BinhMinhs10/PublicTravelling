        function addMarkerForEdit(location, atCells){
            var marker = new google.maps.Marker({
                position: location,
                draggable: true,
                atCells: atCells
            });

			//	Event dragend the marker
			google.maps.event.addListener(marker, "dragend", function(event) {
				// Change address display on table
				geocodeToAddress( event.latLng , marker.atCells );
				if(endablePlan===0){
					document.getElementById('finis'+orders[orders.length-1]).value='';
				}
				// If has more than two marker, direct the route
				if(markers.length>1){
					var route = prepareMarkers(markers);
					calculateAndDisplayRoute(directionsService, directionsDisplay, route);
					endablePlan = 1;
				}
			});		
			
			// Event right click on marker, will display menu marker
			google.maps.event.addListener(marker,'rightclick', function(event){
				contextMenu.marker = this;
				displayMarkerMenu = true;
				google.maps.event.trigger(map, 'rightclick', event);
			});


            markers.push(marker);   //  add marker to markers array
        }