var positions = [];
var cells= [];
var atCells = [];

for(var i=0; i< routes.length; i++){
    positions.push({lat: routes[i].start_latitude, lng: routes[i].start_longitude});
    positions.push({lat: routes[i].finish_latitude,lng: routes[i].finish_longitude});
    cells.push('start'+(i+1));
    cells.push('finis'+(i+1));
}

for(var i=0; i< positions.length; i++){
    atCells[i] = [cells[i]];
    for(var j=i+1; j< positions.length-1; j++){
        if(positions[i].lat === positions[j].lat && positions[i].lng === positions[j].lng && positions[i].lat !== null){
            atCells[i].push(cells[j]);
        }
    }
}

for(var i=0; i< atCells.length; i++){
    if(atCells[i].length===1){
        if( atCells[i][0]!=='start1'){
            atCells[i] = 'delete';
        }
    }else{
        for (var j=i+1; j< atCells.length-1; j++){
            if(atCells[j].includes(atCells[i][atCells[i].length-1])){
                atCells[j] = 'delete';
            }
        }
    }
}

while(atCells.indexOf('delete') !== -1){
    atCells.splice(atCells.indexOf('delete'),1);
}

var uniquePositions = new Set(positions.map(e => JSON.stringify(e))); //make unique
uniquePositions = Array.from(uniquePositions).map(e => JSON.parse(e)); // tranform to array
uniquePositions = uniquePositions.filter( el => el.lat !== null ); // make have not null element

for(var i=0; i< uniquePositions.length; i++){
    addMarkerForEdit(uniquePositions[i],atCells[i]);
}

for (var i = markers.length - 1; i >= 0; i--) {
    geocodeAddressForMarker(markers[i]);
}

google.maps.event.addDomListener(window, 'load', initMap);
