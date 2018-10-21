		/**
		 * To delete Marker on table when click delete marker
		 * @param  {Marker} marker ,which would like to delete
		 */
		function deleteMarkerOnTable(marker){
			var atCells = marker.atCells;
			//	More than two marker
			if(markers.length>2){
				//	If it be the last marker, remove it and set null all cell it be displayed on
				if(markers.indexOf(marker) === (markers.length-1)){
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
					}
					removeMarker(marker);
				}
				else{
					//	Not the last marker, delete row which it be the start marker
					var lastInd= 0;
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
						if (atCells[i].slice(0,5) === 'start'){
							var ind = parseInt(atCells[i].slice(5,atCells[0].length));
							ind = orders.indexOf(ind);
							lastInd = (lastInd > ind)? lastInd : ind;
						}
					}
					delRow(document.getElementById('delRow'+orders[lastInd]));
				}
			}else{
				// Only less than 2 marker
				// Has one row and delete the start, make the finish maker become the start marker
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
					// Has only start or only finish marker, remove it
					removeMarker(marker);
					for (var i = atCells.length - 1; i >= 0; i--) {
						document.getElementById(atCells[i]).value = '';
					}	
				}				 
			}
		}

		function reloadTable(){
			var myTable = document.getElementById('routes');
			if(myTable.rows.length>=3){
				var finish = document.getElementById('finis'+orders[myTable.rows.length-2]);
				var start = document.getElementById('start'+orders[myTable.rows.length-2]);
				while(finish.value === '' && start.value ==='' && myTable.rows.length>2){
					myTable.deleteRow(myTable.rows.length-1);
					orders.pop();
					finish = document.getElementById('finis'+orders[myTable.rows.length-2]);
					start = document.getElementById('start'+orders[myTable.rows.length-2]);
				}
			}			
		}