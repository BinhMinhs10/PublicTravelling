		/**
		 * Geocode address for searchStart
		 * @param  {String} addressString , address which enter on startBox
		 * @param  {int} markerId   , the id of the marker on this startBox
		 */
    	function geocodeAddressForSearchStart(addressString, markerId) {
	        geocoder.geocode({'address': addressString},
	        	function(results, status) {
		        	if (status === 'OK') {
		        		myLatLng = results[0].geometry.location; //	get the location
		        		var event={
		        			latLng: myLatLng
		        		};
		        		if(markerId !== -1){
		        			// Update marker if searchBox has a marker
		        			markers[markerId].setPosition(myLatLng);
		        			google.maps.event.trigger(markers[markerId],'dragend', event);
		        			
		        		}
		        		else{
		        			//	Add new marker if searchBox has no marker
		  					google.maps.event.trigger(map, 'click', event);
		  					map.panTo(myLatLng);
		        		}
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}

      	/**
		 * Geocode address for searchFinish
		 * @param  {String} addressString , address which enter on finishtBox
		 * @param  {int} markerId   , the id of the marker on this finishBox
		 * @param  {int} preMarkerId   , the id of the marker on this startBox
		 * @param  {array} atCells   , the atCells attribute prpared for new marker
		 */
    	function geocodeAddressForSearchFinish(addressString, markerId, preMarkerId, atCells, rowId) {
	        geocoder.geocode({'address': addressString},
	        	function(results, status) {
		        	if (status === 'OK') {
		        		myLatLng = results[0].geometry.location;
		        		var event={
		        			latLng: myLatLng
		        		};
		        		if(markerId !== -1){
		        			//	Update marker if searchBox has marker
		        			markers[markerId].setPosition(myLatLng);
		        			google.maps.event.trigger(markers[markerId],'dragend', event);
		        		}
		        		else{
		        			map.panTo(myLatLng);
		        			//	Add new marker if searchBox has no marker
		  					if(preMarkerId === (markers.length-1) && rowId === orders[orders.length-1]){
		  						// If marker on startBox is the last marker and the box is the last box, add new by click map
		  						google.maps.event.trigger(map, 'click', event);
		  					}else{
		  						//	If not, add manually
								geocodeToAddress(event.latLng, atCells);
								insertMarker(map, event.latLng, atCells, (preMarkerId+1));
							}
		        		}
		        	} else {
		            	alert('Geocode was not successful for the following reason: ' + status);
		          	}
	        });
      	}      	

		/**
		 * Geocode latLng to address
		 * @param  {Object} location   , location of marker would like to get address
		 * @param  {array} elementIds , all cells id the marker display on it
		 */
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