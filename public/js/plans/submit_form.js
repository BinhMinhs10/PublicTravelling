$(document).ready(function(){
	$('button#createPlanButton').on('click', function() {
		if(endablePlan===1){
			alert('You should end plan first!');
		}
		else if($("#createPlanForm").valid()&& $("#routeForm").valid()){
    		$('form#createPlanForm').trigger('submit');
    	}
	});
	$("#createPlanForm").submit(function(event) {
		//event.preventDefault();
		var routes = [];
		for(var i=0; i< orders.length; i++){
			var idMarkerStart = findMarker('start'+orders[i]);
			var idMarkerFinish = findMarker('finis'+orders[i]);
			$("#vehicle"+orders[i]).val($("#displayValueVehicle"+orders[i]).val());
			$("#activities"+orders[i]).val($("#displayValueActivities"+orders[i]).val());
			var route = {
				no: i,
				start_latitude: markers[idMarkerStart].position.lat(),
				start_longitude: markers[idMarkerStart].position.lng(),
				starting_time: $('#timeStart'+orders[i]).val(),
				finish_latitude: (idMarkerFinish===-1)? null : markers[idMarkerFinish].position.lat(),
				finish_longitude: (idMarkerFinish===-1)? null : markers[idMarkerFinish].position.lng(),
				finish_time: $('#timeStart'+orders[i]).val(),
				vehicle: $('#vehicle'+orders[i]).val(),
				activities: $('#activities'+orders[i]).val()
			}
			if(i=== orders.length-1) {
				route.finish_latitude = markers[0].position.lat();
				route.finish_longitude = markers[0].position.lng();
			}
			routes.push(route);
		}
		$('#routesPlan').val(JSON.stringify(routes));
	});
});