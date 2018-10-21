        var map;
        var directionsService;
        var directionsDisplay;    
        var markers = [];   //  the array save all maker on the map
        var geocoder = new google.maps.Geocoder();
        var positions = [];
        var checkin;
        for(var i=0; i< routes.length; i++){
            positions.push({lat: routes[i].start_latitude, lng: routes[i].start_longitude});
            positions.push({lat: routes[i].finish_latitude,lng: routes[i].finish_longitude});
        }
        var uniquePositions = new Set(positions.map(e => JSON.stringify(e))); //make unique
        uniquePositions = Array.from(uniquePositions).map(e => JSON.parse(e)); // tranform to array
        uniquePositions = uniquePositions.filter( el => el.lat !== null ); // make have not null element

        for(var i=0; i< uniquePositions.length; i++){
            addMarkerForShow(uniquePositions[i]);
        }
        for (var i = markers.length - 1; i >= 0; i--) {
            geocodeAddressForMarker(markers[i]);
        }
        google.maps.event.addDomListener(window, 'load', initMap);