function dropdownForVehicle(element, argument) {
	document.getElementById('displayValueVehicle'+argument).value=element.options[element.selectedIndex].text; 
	document.getElementById('vehicle'+argument).value=element.options[element.selectedIndex].value;
}

function dropdownForActivities(element, argument){
	document.getElementById('displayValueActivities'+argument).value=element.options[element.selectedIndex].text; 
	document.getElementById('activities'+argument).value=element.options[element.selectedIndex].value;
	$("#displayValueActivities"+argument).valid();
}