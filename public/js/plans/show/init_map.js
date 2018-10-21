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
            for (var i = markers.length - 1; i >= 0; i--) {
                markers[i].setMap(map);
            }

            var route = markers.concat([markers[0]]);
            route = prepareMarkers(route);
            calculateAndDisplayRoute(directionsService, directionsDisplay, route);

            var myTable = document.getElementById("routes");
            for(var i=0; i< routes.length; i++){
                var newRow = myTable.insertRow(-1);
                
                var markerStartId = findMarker(routes[i].start_latitude, routes[i].start_longitude);
                var markerFinishId = findMarker(routes[i].finish_latitude, routes[i].finish_longitude);

                //  Create the startBox cell for new row
                var startBox = document.createElement("div");
                startBox.innerHTML = markers[markerStartId].strAdd;
                

                //  Create timeStartBox
                var timeStartBox = document.createElement("div");
                timeStartBox.innerHTML = routes[i].starting_time;

                //  Create finishBox
                var finishBox = document.createElement("div");
                finishBox.innerHTML = (markerFinishId===-1) ? null : markers[markerFinishId].strAdd;

                //  Create timeEndBox
                var timeEndBox = document.createElement("div");
                timeEndBox.innerHTML = routes[i].finish_time;         

                //  Create vehicleBox
                var vehicleBox = document.createElement("div");
                vehicleBox.innerHTML = routes[i].vehicle;

                //  Create activitiesBox
                var activitiesBox = document.createElement("div");
                activitiesBox.innerHTML = routes[i].activities;


                var currentCell = newRow.insertCell(-1);
                currentCell.appendChild(startBox);

                currentCell = newRow.insertCell(-1);
                currentCell.appendChild(timeStartBox);

                currentCell = newRow.insertCell(-1);
                currentCell.appendChild(finishBox);

                currentCell = newRow.insertCell(-1);
                currentCell.appendChild(timeEndBox);

                currentCell = newRow.insertCell(-1);
                currentCell.appendChild(vehicleBox);

                currentCell = newRow.insertCell(-1);
                currentCell.appendChild(activitiesBox);          
            }             
            getLocation();
           
        }
        function getLocation() {
            console.log("location1");
            if(navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    checkin = "VN";
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                   
                    var latlng = new google.maps.LatLng(latitude, longitude);
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'location': latlng}, function(results, status) {

                      if (status == 'OK') {
                        if (results[0]) {
                            console.log(checkin);
                           checkin = results[0].formatted_address;
                           console.log(results[0]['formatted_address']);
                        }else{alert("error1");}
                      }else{alert(status);}
                    }); 
                });
            } else {
                checkin = "Not found";
            }
        }