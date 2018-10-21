		function addRow(cell){
			if(endablePlan===0){
				alert("Your plan has just ended, let undo end plan if you would like to make some change!");       		
        	}else{
        		doAddRow(cell);
        	}
		}

		/**
		 * To prepare for adding a new row on table
		 * @param {HTML Object} cell ,the cell contain element can call this function
		 * Will call add function in specific case
		 */
		function doAddRow(cell){
	        var myTable = document.getElementById("routes");
	        var clickedRowIndex = cell.parentNode.parentNode.rowIndex;	//	index of row which click on it: 0,1,2,...
			var finish = document.getElementById('finis'+orders[clickedRowIndex-1]);	// cause orders=[1,...]
			var start = document.getElementById('start'+orders[clickedRowIndex-1]);
			if(findMarker(finish.id)===-1){
				var marker = markers[findMarker(start.id)];
			}else{
				var marker = markers[findMarker(finish.id)]
			}
			//	If marker start box is null, can not add a new row
			if(start.value ===''){
	        	alert('Please complete this route before adding new route!');
	        }else{
	        	//	If marker finish box is null, add new row with marker sart box same as this marker start box
	        	if(finish.value ===''){
	        		add(clickedRowIndex, marker, 'start');
	        	//	If not, add new row with marker sart box same as this marker finish box
	        	}else{
	        		add(clickedRowIndex, marker, 'finis');
	        	}
	        }

		}

		/**
		 * To add a new row on table
		 * @param {int} index ,the index of current row had just click on it
		 * @param {String} mode  , accept 'start' or 'finish', then it will copy the value in one of two box on previous row
		 */
        function add(index, marker, mode){
        	var myTable = document.getElementById("routes");
        	var newRowIndex = ++currentIndex;	//	index of elements in row which will be added
	        var newRow = myTable.insertRow(index+1);	//	insert a row after the row has just been clicked on

	        orders.splice(index,0,newRowIndex);	//	insert index of elements in new row to order array

	        //	Create the startBox cell for new row
	        var startBox = document.createElement("input");
	        startBox.setAttribute("name", "start" + newRowIndex);
	        startBox.setAttribute("id", "start" + newRowIndex);
	        startBox.setAttribute("class","form-control");
	        startBox.setAttribute("disabled",true);

	        // Update atCells attribute for marker will be display on this box
	        var previousRowIndex = orders[index-1];
	        startBox.setAttribute("value", document.getElementById(mode+previousRowIndex).value);
	        var atCells = marker.atCells;
	        atCells.push("start" + newRowIndex);
	        markers[markers.indexOf(marker)].atCells = atCells;

	        //	Create timeStartBox
	        var timeStartBox = document.createElement("input");
	        timeStartBox.setAttribute("name", "timeStart" + newRowIndex);
	        timeStartBox.setAttribute("id", "timeStart" + newRowIndex);
	        timeStartBox.setAttribute("class","form-control");
	        timeStartBox.setAttribute("type", "text");

	        //	Create finishBox
	        var finishBox = document.createElement("input");
	        finishBox.setAttribute("name", "finis" + newRowIndex);
	        finishBox.setAttribute("id", "finis" + newRowIndex);
	        finishBox.setAttribute("class","form-control");

	        //	Create timeEndBox
	        var timeEndBox = document.createElement("input");
	        timeEndBox.setAttribute("name", "timeEnd" + newRowIndex);
	        timeEndBox.setAttribute("id", "timeEnd" + newRowIndex);
	        timeEndBox.setAttribute("type", "text");
	        timeEndBox.setAttribute("class","form-control");	        

	        //	Create vehicleBox
	        var vehicleBox = document.createElement("div");
	        vehicleBox.setAttribute("class", "my_dropdown_list");

	        var vehicleSelectBox = document.createElement("select");
	        vehicleSelectBox.setAttribute("class","form-control");
	        vehicleSelectBox.setAttribute("onchange","dropdownForVehicle(this,"+newRowIndex+");");
	        var option1 = document.createElement("option");
	        var option2 = document.createElement("option");
	        option2.setAttribute("value","Motorbike");
	        option2.innerHTML= "Motorbike";
	        var option3 = document.createElement("option");
	        option3.setAttribute("value","Car");
	        option3.innerHTML= "Car";
	        var option4 = document.createElement("option");
	        option4.setAttribute("value","Bus");
	        option4.innerHTML= "Bus";
	        vehicleSelectBox.appendChild(option1);
	        vehicleSelectBox.appendChild(option2);
	        vehicleSelectBox.appendChild(option3);
	        vehicleSelectBox.appendChild(option4);

	        var displayVehicleBox = document.createElement("input");
	        displayVehicleBox.setAttribute("id","displayValueVehicle"+newRowIndex);
	        displayVehicleBox.setAttribute("name","displayValueVehicle"+newRowIndex);
	        displayVehicleBox.setAttribute("type","text");
	        displayVehicleBox.setAttribute("class","form-control my_dropdown_box");
	        displayVehicleBox.setAttribute("placeholder","Enter/Select a vehicle");
	        displayVehicleBox.setAttribute("onfocus","this.select()");

	        var inputVehicleBox = document.createElement("input");
	        inputVehicleBox.setAttribute("id","vehicle"+newRowIndex);
	        inputVehicleBox.setAttribute("name","vehicle"+newRowIndex);
	        inputVehicleBox.setAttribute("type","hidden");

	        vehicleBox.appendChild(vehicleSelectBox);
	        vehicleBox.appendChild(displayVehicleBox);
	        vehicleBox.appendChild(inputVehicleBox);

	        //	Create activitiesBox
	        var activitiesBox = document.createElement("div");
	        activitiesBox.setAttribute("class", "my_dropdown_list");

	        var activitiesSelectBox = document.createElement("select");
	        activitiesSelectBox.setAttribute("class","form-control");
	        activitiesSelectBox.setAttribute("onchange","dropdownForActivities(this,"+newRowIndex+");");
	        var option1 = document.createElement("option");
	        var option2 = document.createElement("option");
	        option2.setAttribute("value","Move");
	        option2.innerHTML= "Move";
	        var option3 = document.createElement("option");
	        option3.setAttribute("value","Take photo");
	        option3.innerHTML= "Take photo";
	        var option4 = document.createElement("option");
	        option4.setAttribute("value","Camping");
	        option4.innerHTML= "Camping";
	        activitiesSelectBox.appendChild(option1);
	        activitiesSelectBox.appendChild(option2);
	        activitiesSelectBox.appendChild(option3);
	        activitiesSelectBox.appendChild(option4);

	        var displayActivitiesBox = document.createElement("input");
	        displayActivitiesBox.setAttribute("id","displayValueActivities"+newRowIndex);
	        displayActivitiesBox.setAttribute("name","displayValueActivities"+newRowIndex);
	        displayActivitiesBox.setAttribute("type","text");
	        displayActivitiesBox.setAttribute("class","form-control my_dropdown_box");
	        displayActivitiesBox.setAttribute("placeholder","Enter/Select an activity");
	        displayActivitiesBox.setAttribute("onfocus","this.select()");

	        var inputActivitiesBox = document.createElement("input");
	        inputActivitiesBox.setAttribute("id","activities"+newRowIndex);
	        inputActivitiesBox.setAttribute("name","activities"+newRowIndex);
	        inputActivitiesBox.setAttribute("type","hidden");

	        activitiesBox.appendChild(activitiesSelectBox);
	        activitiesBox.appendChild(displayActivitiesBox);
	        activitiesBox.appendChild(inputActivitiesBox);

	        //	Create addRowNox
	        var addRowBox = document.createElement("i");
	        addRowBox.setAttribute("id", "addRow" + newRowIndex);
	        addRowBox.setAttribute("name", "addRow" + newRowIndex);
	        addRowBox.setAttribute("onclick", "addRow(this)");
	        addRowBox.setAttribute("class","fa fa-plus custom_fa");

	        //	Create delRowBox
	        var delRowBox = document.createElement("i");
	        delRowBox.setAttribute("id", "delRow" + newRowIndex);
	        delRowBox.setAttribute("name", "delRow" + newRowIndex);
	        delRowBox.setAttribute("onclick", "delRow(this)");
	        delRowBox.setAttribute("class","fa fa-minus custom_fa");	        

	        // Insert startBox at the end of the blank row
	        var currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(startBox);

	        //	Insert timeStartBox at the end of the row, it will after startBox
	        currentCell = newRow.insertCell(-1);
	        currentCell.appendChild(timeStartBox);

	        //	Insert the remaining boxes in-ordering at the end of the row
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

	        //	Create SearchBox on finshBox element
		  	var searchFinish = new google.maps.places.SearchBox(finishBox);
		  	$("#"+startBox.id).on('focus',function () {
			    tempAddress = startBox.value;
			});
			$("#"+finishBox.id).on('focus',function () {
			    tempAddress = finishBox.value;
			});
		  	
		  	$("#"+finishBox.id).on('focusout',function () {
			    if(tempAddress!=='' && finishBox.value === ''){
			    	var markerId = findMarker(finishBox.id);
			    	deleteMarkerOnTable(markers[markerId]);
			    	reloadTable();
			    }
			});
			$("#"+startBox.id).on('focusout',function () {
			    if(tempAddress!=='' && start.value === ''){
			    	var markerId = findMarker(startBox.id);
			    	deleteMarkerOnTable(markers[markerId]);
			    	reloadTable();
			    }
			});
			$("#"+timeEndBox.id).on('focusout',function () {
			    $("#"+timeStartBox.id).valid();
			});

			$("#"+timeStartBox.id).on('focusout',function () {
			    $("#"+timeEndBox.id).valid();
			});
		 
		  	//	Handling event when searchFinish be changed
		  	searchFinish.addListener('places_changed', function(){
		  		var currentOrder = orders.indexOf(newRowIndex);
		  		var markerStartIndex = findMarker(startBox.id);
		  		//	If has no marker on the startBox, can not change this box
		  		if(markerStartIndex === -1){
		  			finishBox.value = '';
		  			alert('Please enter Start Adress first!');
		  		}
		  		else{
			  		var markerFinishIndex = findMarker(finishBox.id);
			  		var address = finishBox.value;
			  		var startAtCells = markers[markerStartIndex].atCells;
			  		var tempAtCells = startAtCells;
			  		var finishAtCells =[finishBox.id];

			  		//	Add cells id which after this box id to atCells attribute of new marker will be add on this box
			  		for (var i = 0; i < startAtCells.length ; i++) {
			  			if(orders.indexOf(parseInt(startAtCells[i].slice(5,startAtCells[i].length)))>currentOrder){
			  				finishAtCells.push(startAtCells[i]);
			  				tempAtCells[i]= 'delete';
			  			}	
			  		}
			  		
			  		// Delete that cells id on atCells attribute of the marker on startbox of this row
			  		while(tempAtCells.indexOf('delete') !== -1){
			  			tempAtCells.splice(tempAtCells.indexOf('delete'),1);
			  		}
			  		markers[markerStartIndex].atCells = tempAtCells;

			  		if(markerFinishIndex===-1) finishBox.value = '';
			  		var rowId = parseInt(finishBox.id.slice(5,finishBox.id.length));
			  		geocodeAddressForSearchFinish(address, markerFinishIndex, markerStartIndex, finishAtCells, rowId);
			  	}
		  	});

			jQuery('#'+timeStartBox.id).datetimepicker({
				format:'Y-m-d H:i',
				minDate: Date.now(),
				onChangeDateTime:logic,
				onShow:logic
			});
			jQuery('#'+timeEndBox.id).datetimepicker({
				format:'Y-m-d H:i',
				minDate: Date.now(),
				onChangeDateTime:logic,
				onShow:logic
			});	

			$('#routes').trigger('rowAddOrRemove');		  	
        }