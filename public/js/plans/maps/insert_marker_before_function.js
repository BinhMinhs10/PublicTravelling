		/**
		 * To insert a marker before one marker
		 * @param  {Marker} marker ,which marker be choose to insert before it another marker
		 */
		function insertBefore(marker){
			ind = markers.indexOf(marker);

			//	calculate the center point latLong of this marker and the previous
			var lat1 = markers[ind - 1].position.lat();
			var lat2 = markers[ind].position.lat();
			var lng1 = markers[ind - 1].position.lng();
			var lng2 = markers[ind].position.lng();
			latLng = {
				lat: (lat1+lat2)/2,
				lng: (lng1+lng2)/2
			};

			//	set atCells attribute for new marker, and insertMarker
			var oldAtCells = marker.atCells;
			var newAtCells =[];
			var firstOldCell = oldAtCells[0];
			var indexOfFirstOldCell = parseInt(firstOldCell.slice(5,firstOldCell.length)); 
			/*slice will cut array from a to b
			 *ex: str='start4'
			 *str.slice(5,str.lenght) will return '4'
			 */
			addRow(document.getElementById('addRow'+indexOfFirstOldCell));
			var newRowIndex = currentIndex;
			document.getElementById('finis'+newRowIndex).value= 
			document.getElementById(oldAtCells[0]).value;
			newAtCells.unshift(oldAtCells.shift());
			oldAtCells.shift();
			newAtCells.push('start'+newRowIndex);	//	add to the finishing of the array
			oldAtCells.unshift('finis'+newRowIndex); // add to the beginning of the array
			marker.atCells = oldAtCells;
			geocodeToAddress(latLng, newAtCells);
			insertMarker(map, latLng, newAtCells, ind);
			console.log(markers);
		}