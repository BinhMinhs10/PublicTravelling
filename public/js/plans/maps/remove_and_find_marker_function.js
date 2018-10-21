		/**
		 * To remove a marker
		 * @param  {Marker} marker ,which would like to remove
		 */
		function removeMarker(marker){
			var ind = markers.indexOf(marker);
			marker.setMap(null);	// remove on map
			markers.splice(ind,1);	//	remove on aray
			// If has more than two marker, direct the route
			if(markers.length>1){
				var route = prepareMarkers(markers);
				calculateAndDisplayRoute(directionsService, directionsDisplay, route);
			}else{
				//	Only one marker in map, delete direction and reset it
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
			return -1;
		}