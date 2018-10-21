        function geocodeAddressForMarker(marker) {
            geocoder.geocode({'location': marker.position}, function(results, status) {
                    if (status === 'OK') {
                        markers[markers.indexOf(marker)].strAdd = results[0].formatted_address;
                    } else {
                        alert('Geocode was not successful for the following reason: ' + status);
                    }
            });
        } 