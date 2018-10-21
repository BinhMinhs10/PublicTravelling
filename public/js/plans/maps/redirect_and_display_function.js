		/**
		 * Calculate and display route 
		 * @param  {DirectionsService} directionsService 
		 * @param  {directionsDisplay} directionsDisplay 
		 * @param  {Object} route    , has all attribute need for route method of directionService
		 */
		function calculateAndDisplayRoute(directionsService, directionsDisplay, route){
			directionsDisplay.setPanel(document.getElementById('right-panel')); //	display the guide in right panel
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

		/**
		 * Tranform markers to waypoint , start, finish
		 * @param  {Array} markers , array contain all marker on plan
		 */
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