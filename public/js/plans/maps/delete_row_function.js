        /**
         * To delete a row on table
         * @param  {HTML Object} cell ,the cell contain element which call this function
         */
        function delRow(cell){
	        var myTable = document.getElementById("routes");
	        var clickedRowIndex = cell.parentNode.parentNode.rowIndex;	//	index of row which click on it, click row 1, return 1
			var finish = document.getElementById('finis'+orders[clickedRowIndex-1]);	// cause orders=[1,...]
			var start = document.getElementById('start'+orders[clickedRowIndex-1]);
        	if(endablePlan===0){
				alert("Your plan has just ended, we will roll back one step!");
				endablePlan = 1;
				document.getElementById('finis'+orders[orders.length-1]).value='';
				// If has more than two marker, direct the route
				var route = prepareMarkers(markers);
				calculateAndDisplayRoute(directionsService, directionsDisplay, route);        		
        	}
	 			//If click on first row, and now, table only has this row, can not delete row
	  		else if(clickedRowIndex===1 && myTable.rows.length===2){
	  			alert("You can not delete this row!");
	  		}
	        else{
	        	var markerStartIndex = findMarker(start.id);
	        	var atCellsStart = markers[markerStartIndex].atCells;
	        	myTable.deleteRow(clickedRowIndex);	//	delete row
		        orders.splice(clickedRowIndex-1,1);	//	delete order in orders array

		        var k = atCellsStart.indexOf(start.id);
				atCellsStart.splice(k,1); //	should check k!=-1
	        	//	If route only has marker start, delete row and update atCells attribute of the marker start       	
		        if(finish.value ===''){
				    markers[markerStartIndex].atCells = atCellsStart;

				/*If route has marker start and marker finish, 
				 *add cells id in atCells attribute of marker on startBox to atCells attribue of marker on finishBox,
				 *delete marker in start box
				 */	
		        }else{
		        	var markerFinishIndex = findMarker(finish.id);
		        	var atCellsFinish = markers[markerFinishIndex].atCells;
		        	var temp = finish.value;
	        		
	        		var m = atCellsFinish.indexOf(finish.id);
		        	atCellsFinish.splice(m,1);

		        	atCellsFinish = atCellsStart.concat(atCellsFinish);	//	merge two arrays
		        	markers[markerFinishIndex].atCells = atCellsFinish;
		        	removeMarker(markers[markerStartIndex]);
		        	for (var i = 0; i < atCellsFinish.length; i++) {
		        		document.getElementById(atCellsFinish[i]).value = temp;
		        	}	        	
		        }

		        
		        document.getElementById('start'+orders[0]).disabled = false;
		        
	        }

	        $('#routes').trigger('rowAddOrRemove');                	
        }	