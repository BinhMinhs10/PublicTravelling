        /**
         * Initialize the map
         */
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

			//display route for edit view
			if(markers.length>0){
				endablePlan=0;
				for (var i = markers.length - 1; i >= 0; i--) {
	                markers[i].setMap(map);
	            }

	            var route = markers.concat([markers[0]]);
	            route = prepareMarkers(route);
	            calculateAndDisplayRoute(directionsService, directionsDisplay, route);

	            var myTable = document.getElementById("routes");
				document.getElementById('start1').value= markers[0].strAdd;
				document.getElementById('timeStart1').value= routes[0].starting_time;
				document.getElementById('finis1').value= (findMarker('finis1')===-1)? null: markers[1].strAdd ;
				document.getElementById('timeEnd1').value= routes[0].finish_time;
				document.getElementById('vehicle1').value= routes[0].vehicle;
				document.getElementById('displayValueVehicle1').value= routes[0].vehicle;
				document.getElementById('activities1').value= routes[0].activities;
				document.getElementById('displayValueActivities1').value= routes[0].activities;

				for(var i=1; i< routes.length; i++){
				    doAddRow(document.getElementById('addRow'+i));
					document.getElementById('timeStart'+(i+1)).value= routes[i].starting_time;
					document.getElementById('finis'+(i+1)).value= (findMarker('finis'+(i+1))===-1)? null: markers[findMarker('finis'+(i+1))].strAdd ;
					document.getElementById('timeEnd'+(i+1)).value= routes[i].finish_time;
					document.getElementById('vehicle'+(i+1)).value= routes[i].vehicle;
					document.getElementById('displayValueVehicle'+(i+1)).value= routes[i].vehicle;
					document.getElementById('activities'+(i+1)).value= routes[i].activities;				            
					document.getElementById('displayValueActivities'+(i+1)).value= routes[i].activities;				            
				}
				document.getElementById('finis'+routes.length).value = markers[0].strAdd;
				var undoBtn = document.getElementById('undoEndPlanButton');
				if(undoBtn!==null) undoBtn.removeAttribute('disabled');
				var endBtn = document.getElementById('endPlanButton');
				if(endBtn !==null) endBtn.setAttribute("disabled", true);
			}else{
				var undoBtn = document.getElementById('undoEndPlanButton');
				if(undoBtn!==null) undoBtn.setAttribute("disabled", true);
				var endBtn = document.getElementById('endPlanButton');
				if(endBtn !==null) endBtn.setAttribute("disabled", true);
			}

			//	Add SearchBox for sartBox and finishBox of the first row
			var start = document.getElementById('start1');
		  	var finish = document.getElementById('finis1');
		  	var addRow1 = document.getElementById('addRow1');
		  	var searchStart = new google.maps.places.SearchBox(start);
		  	var searchFinish = new google.maps.places.SearchBox(finish);

		  	//	Handling event when searchStart be changed
		  	searchStart.addListener('places_changed', function(){
		  		var markerStartIndex = findMarker(start.id);
		  		var address = start.value;
		  		if(markerStartIndex===-1) start.value = '';
		  		geocodeAddressForSearchStart(address, markerStartIndex);
		  		
		  	});
		  	$("#"+start.id).on('focus',function () {
			    tempAddress = start.value;
			});
			$("#"+finish.id).on('focus',function () {
			    tempAddress = finish.value;
			});
			$("#"+start.id).on('focusout',function () {
			    if(tempAddress!=='' && start.value === ''){
			    	var markerId = findMarker(start.id);
			    	deleteMarkerOnTable(markers[markerId]);
			    	reloadTable();
			    }
			});
		  	$("#"+finish.id).on('focusout',function () {
			    if( tempAddress!=='' && finish.value === ''){
			    	var markerId = findMarker(finish.id);
			    	deleteMarkerOnTable(markers[markerId]);
			    	reloadTable();
			    }
			});

			$("#timeStart1").on('focusout',function () {
			    $("#timeEnd1").valid();
			});

			$("#timeEnd1").on('focusout',function () {
			    $("#timeStart1").valid();
			});

			$("#start_at").on('focusout',function () {
			    $("#end_at").valid();
			    for(var i=0; i<orders.length;i++){
			    	$('#timeStart'+orders[i]).valid();
			    }
			});

			$("#end_at").on('focusout',function () {
			    $("#start_at").valid();
			    for(var i=0; i<orders.length;i++){
			    	$('#timeEnd'+orders[i]).valid();
			    }
			});

			$("#member").on('focusout',function () {
			    var gets = $("#member").val();
			    while(gets[0] === '0' ){
			    	gets = gets.substring(1,gets.length);
			    }
			    $("#member").val(gets);
			});
			
		  	// Event of finish entering SearchFinish box
		  	searchFinish.addListener('places_changed', function(){
		  		var currentOrder = 0;
		  		var markerStartIndex = findMarker(start.id);
		  		//	If has no marker on the startBox, can not change this box
		  		if(markerStartIndex === -1){
		  			finish.value = '';
		  			alert('Please enter Start Adress first!');
		  		}
		  		else{
			  		var markerFinishIndex = findMarker(finish.id);
			  		var address = finish.value;
			  		var startAtCells = markers[markerStartIndex].atCells;
			  		var tempAtCells = startAtCells;
			  		var finishAtCells =[finish.id];

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

			  		if(markerFinishIndex===-1) finish.value = '';
			  		var rowId = parseInt(finish.id.slice(5,finish.id.length));
			  		geocodeAddressForSearchFinish(address, markerFinishIndex, markerStartIndex, finishAtCells, rowId);
			  	}
		  	});			
			
		  	//	Handling event when click map
			google.maps.event.addListener(map,'click', function(event) {
				//	Click on map when menu display, menu will hide
				if(contextMenu.isVisible_ == true){
					contextMenu.hide();
				}else if(endablePlan===0){
					alert("Your plan has just ended, let undo end plan if you would like to make some change!");					
				}else{
					var myTable = document.getElementById('routes');
					var currentRow = orders[orders.length-1];
					var finish = document.getElementById('finis'+currentRow);
					var start = document.getElementById('start'+currentRow);

					if(finish.value !== ''){
						if(start.value !== ''){
							//	If all finish and start box has a marker, add a new row for new marker
							addRow(document.getElementById('addRow'+currentRow));
							currentRow = orders[orders.length-1];	// after addRow function, orders be changed
							//console.log(orders);
							geocodeToAddress(event.latLng,['finis'+(currentRow)]);
							insertMarker(map,event.latLng, ['finis'+(currentRow)], markers.length);
						}
						else{
							//	finishBox has marker, but startBox has no
							//	only for first row, when delete at searchbox, then click map
							geocodeToAddress(event.latLng,['start'+currentRow]);
							insertMarker(map,event.latLng, ['start'+ currentRow], 0);
						}
						
					}else{
						if(start.value !== ''){
							//	startBox has marker, but finishBox has no
							geocodeToAddress(event.latLng,['finis'+currentRow]);
							insertMarker(map,event.latLng, ['finis'+currentRow], markers.length);
						}else{
							// all startBox and finishBox has no marker
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
			menuItems.push({className:'context_menu_item', eventName:'undo_end_plan', label:'Undo End plan', id:'undoEndPlan'});
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
				/*Display endPlan menu when has more than two marker
				 *endablePlan is set equal 1
				 *menu of marker not display or only on last marrker
				 */
			    document.getElementById('endPlan').style.display=(markers.length>=2 && endablePlan === 1 && ((!displayMarkerMenu)||(displayMarkerMenu&&markers.indexOf(contextMenu.marker)=== (markers.length-1))))?'block':'none';
			    document.getElementById('undoEndPlan').style.display=(markers.length>=2 && endablePlan === 0 && ((!displayMarkerMenu)||(displayMarkerMenu&&markers.indexOf(contextMenu.marker)=== (markers.length-1))))?'block':'none';
			    //	Display deleteMarker menu only when right click on marker
		    	document.getElementById('deleteMarker').style.display= (displayMarkerMenu && endablePlan===1) ?'block':'none';
		    	//	Display insertAfter menu when right click on marker but the last marker
		    	document.getElementById('insertAfter').style.display= (displayMarkerMenu && endablePlan===1 && (markers.indexOf(contextMenu.marker)!== (markers.length-1)) )?'block':'none';
		    	//	Display insertBefore menu when right click on marker but the first marker
		    	document.getElementById('insertBefore').style.display= (displayMarkerMenu && endablePlan===1 && (markers.indexOf(contextMenu.marker)!==0) ) ?'block':'none';
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
						reloadTable();
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
						endPlan();
						break;
					case 'undo_end_plan':
						contextMenu.hide();
						undoEndPlan();
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

		function endPlan(){
			document.getElementById('endPlan').style.display='none';
			
			//	add new row with startBox is last marker, and finishBox is the first
			var myTable = document.getElementById('routes');
			var currentRow = orders[orders.length-1];
			var finish = document.getElementById('finis'+currentRow);
			var start = document.getElementById('start'+currentRow);
			addRow(document.getElementById('addRow'+currentRow));
			currentRow = orders[orders.length-1];	// after addRow function, orders be changed
			document.getElementById('start'+currentRow).value= (finish.value==='')?start.value:finish.value;
			document.getElementById('finis'+currentRow).value=document.getElementById('start'+orders[0]).value;

			var route = markers.concat([markers[0]]);
			route = prepareMarkers(route);
			calculateAndDisplayRoute(directionsService, directionsDisplay, route);
			for (var i = markers.length - 1; i >= 0; i--) {
				markers[i].setDraggable(false);
			}
			for(var i=0; i<orders.length; i++){
				document.getElementById('start'+orders[i]).setAttribute("disabled", true);
				document.getElementById('finis'+orders[i]).setAttribute("disabled", true);
				document.getElementById('addRow'+orders[i]).setAttribute("onclick", null);
				document.getElementById('delRow'+orders[i]).setAttribute("onclick", null);
			}
			document.getElementById('endPlanButton').setAttribute("disabled", true);
			//$('#endPlanButton').prop('disabled', true);
			document.getElementById('undoEndPlanButton').removeAttribute('disabled');
			//$('#undoEndPlanButton').prop('disabled', false);
			endablePlan = 0; //mark that plan is end, this menu never display again if having no change with marker
		}

		function undoEndPlan(){
			document.getElementById('undoEndPlan').style.display='none';
			
			//	delete the last row, update atCell attribute of the last marker
			var tempAtCells = markers[markers.length-1].atCells;
			tempAtCells.pop();
			markers[markers.length-1].atCells = tempAtCells;
			var myTable = document.getElementById('routes');
			myTable.deleteRow(myTable.rows.length-1);
			orders.pop();

			var route = prepareMarkers(markers);
			calculateAndDisplayRoute(directionsService, directionsDisplay, route);
			for (var i = markers.length - 1; i >= 0; i--) {
				markers[i].setDraggable(true);
			}
			for(var i=0; i<orders.length; i++){
				document.getElementById('finis'+orders[i]).removeAttribute('disabled');
				//$('#finis'+orders[i]).prop('disabled', false);
				document.getElementById('addRow'+orders[i]).setAttribute("onclick", 'addRow(this)');
				document.getElementById('delRow'+orders[i]).setAttribute("onclick", 'delRow(this)');
			}
			document.getElementById('start'+orders[0]).removeAttribute('disabled');
			document.getElementById('undoEndPlanButton').setAttribute("disabled", true);
			document.getElementById('endPlanButton').removeAttribute('disabled');
			// $('#start'+orders[0]).prop('disabled', false);
			// $('#endPlanButton').prop('disabled', false);
			// $('#undoEndPlanButton').prop('disabled', true);
			endablePlan = 1; //mark that plan is not end
		}