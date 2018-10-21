        function addMarkerForShow(location){
            var marker = new google.maps.Marker({
                position: location,
            });

            markers.push(marker);   //  add marker to markers array
        }

        function findMarker(lat, lng){
            for (var i = markers.length - 1; i >= 0; i--) {
                if(markers[i].position.lat() === lat && markers[i].position.lng() === lng){
                    return i;
                }
            }
            return -1;
        }