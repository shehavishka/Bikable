<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/ongoingRide.css">
    <title>Ongoing Ride</title>
</head>
<body>
    <div class="floating-panel" id="floating-panel">
        <div class="welcome" id="welcome_message">
            <div id="main-text">
                <h1>RIDE ACTIVE</h1>
            </div>
            <div id="sub-text">
                Your ride started at <?php echo $data['timeStamp'] ?>
            </div>
        </div>

        <div class="info">
            <div class="info_1">
                <div class="info_number" id="time_spent">0min</div>                    
                <div class="info_title">
                    Time Spent
                </div>
            </div>
            <div class="vl"></div>
            <div class="info_2" id="distance">
                <div class="info_number" id="current_fare">0.00</div>
                <div class="info_title">
                    Current Fare
                </div>
            </div>
        </div>

        <!-- <div class="temp">
            <div class="row">
                <div class="title">Updated</div>
                <div class="data" id="date"></div>
            </div>
            <div class="row">
                <div class="title">Latitude, Longitude</div>
                <div class="data">
                <span id="lat"></span>, <span id="lng"></span>
                </div>
            </div>
        </div> -->

            <!-- div for two buttons, cross and directions -->
        <div class="action_buttons">
            <div id="closest_DA">Closest Area</div>

            <div id="end_ride"><div id ="white_text">End Ride</div></div>
        </div>
    </div>

    <div class="map" id="map-layer">
        <!-- <h1>MAP IS HERE</h1> -->
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdJd3svFUpixnG_ebYv6_dDQQHI1QPvlM&callback=initMap" async defer>
        </script>
    
        <script type="text/javascript">
            var map;

            function initMap(){
                var mapLayer = document.getElementById("map-layer");
                let infoWindow = new google.maps.InfoWindow();
                var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}

                map = new google.maps.Map(mapLayer, defaultOptions);
                var markers = [];

                const closest_DA = document.getElementById("closest_DA");
                closest_DA.addEventListener("click", function() {closestPoint(areas);});
                const end_ride = document.getElementById("end_ride");
                end_ride.addEventListener("click", function() {endRide();});

                //old map pins
                    // <?php foreach($data['mapDetails'] as $oneObject) : ?>

                    //             var latitude = <?php echo $oneObject->locationLat; ?>;
                    //             var longitude = <?php echo $oneObject->locationLong; ?>

                    //             var marker = new google.maps.Marker({
                    //                 position: new google.maps.LatLng(latitude, longitude),
                    //                 map: map,
                    //                 icon: {url:"<?php echo URLROOT; ?>/public/images/owners/landPageImages/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                    //                 label: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                    //                 labelClass: "marker-position",
                    //                 title: '<?php echo $oneObject->areaName; ?>',
                    //                 id: '<?php echo $oneObject->areaID; ?>'
                    //             });
                    // <?php endforeach; ?>
                //

                const areas = [
                    <?php foreach($data['mapDetails'] as $oneObject) : ?>
                        {
                            id: <?php echo $oneObject->areaID; ?>,
                            position: new google.maps.LatLng(<?php echo $oneObject->locationLat; ?>, <?php echo $oneObject->locationLong; ?>),
                            //type: "info",
                            title: "<?php echo $oneObject->areaName; ?>",
                            label: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                            label_big: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded", fontSize: "45px"},
                            content: "<?php echo $oneObject->areaName; ?>",
                            radius: <?php echo $oneObject->locationRadius; ?>,
                        },
                    <?php endforeach; ?>
                ];
                
                
                areas.forEach(({ position, title, label, label_big, id }, i) => {
                    const marker = new google.maps.Marker({
                        position,
                        map,
                        title,
                        icon: {url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                        label,
                        labelClass: "marker-position",
                    });
                    markers.push(marker);
                });


                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                    (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    // var watchId = navigator.geolocation.watchPosition(function(position) {
                    // var lat = position.coords.latitude;
                    // var lng = position.coords.longitude;
                    // // update the user's location on the map                    
                    // });

                    // infoWindow.setPosition(pos);
                    // infoWindow.setContent("Location found.");
                    // infoWindow.open(map);
                    myLoc = new google.maps.Marker({
                        position: pos,
                        map,
                        title: "My location",
                    });

                    map.setCenter(pos);
                    },
                    () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                    }
                );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }

                function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                    infoWindow.setPosition(pos);
                    infoWindow.setContent(
                        browserHasGeolocation
                        ? "Error: The Geolocation service failed."
                        : "Error: Your browser doesn't support geolocation."
                    );
                    infoWindow.open(map);
                }

                window.initMap = initMap;

                //////////Getting location from user and sending it to the server while also updating the map
                var track = {
                    // (A) INIT
                    rider : <?php echo $data['userID'] ?>,
                    rideLogID: <?php echo $data['rideLogID'] ?>,
                    delay : 10000, // delay between gps update (ms)
                    timer : null,  // interval timer
                    hDate : null,  // html date
                    hLat : null,   // html latitude
                    hLng : null,   // html longitude
                    durationHTML: null, // duration of the ride
                    duration: 0, //duration in seconds
                    fareHTML: null,
                    fare: 0.0, // fare of the ride
                    baseValue: <?php echo($data['fareBaseValue']); ?>, // this should in the future come from the database, since the super admin can set it
                    fareRate: <?php echo($data['fareRate']); ?>, // this should in the future come from the database, since the super admin can set it

                    init : () => {
                    // (A1) GET HTML
                    // track.hDate = document.getElementById("date");
                    // track.hLat = document.getElementById("lat");
                    // track.hLng = document.getElementById("lng");
                    track.fareHTML = document.getElementById("current_fare");
                    track.durationHTML = document.getElementById("time_spent");

                    // (A2) START TRACKING
                    track.update();
                    track.timer = setInterval(track.update, track.delay);
                    },

                    // (B) SEND CURRENT LOCATION TO SERVER
                    update : () => navigator.geolocation.getCurrentPosition(
                    pos => {
                        // (B1) LOCATION DATA
                        var data = new FormData();
                        data.append("req", "update");
                        data.append("id", track.rider);
                        data.append("rideLogID", track.rideLogID);
                        data.append("lat", pos.coords.latitude);
                        data.append("lng", pos.coords.longitude);

                        // console log the form data
                        for (var pair of data.entries()) {
                            console.log(pair[0]+ ', ' + pair[1]); 
                        }
                        //update position on map
                        myLoc.setPosition(new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude));

                        // (B2) AJAX SEND TO SERVER
                        fetch("<?php echo URLROOT;?>/riders/ajax_track", { method:"POST", body:data })
                        .then(res => res.text())
                        .then(txt => { if (txt=="OK") {
                            let now = new Date();
                            //testing data for checking if the position and time is updated properly
                            // track.hDate.innerHTML = now.toString();
                            // track.hLat.innerHTML = pos.coords.latitude;
                            // track.hLng.innerHTML = pos.coords.longitude;

                            // //to update the fare and duration on the html side
                            // track.fare += track.fareRate;
                            // track.fareHTML.innerHTML = track.fare.toFixed(2) + "/=";
                            // track.duration += 10;
                            // track.durationHTML.innerHTML = Math.floor(track.duration / 3600) + "h" + Math.floor((track.duration / 60) % 60) + "m" + track.duration % 60 + "s";

                            //to update the fare and duration on the html side
                            $present = Math.floor(new Date().getTime() / 1000);
                            $rideStartTimeStamp = <?php echo(strtotime($data['rideDetailObject']->rideStartTimeStamp));?>;
                            track.duration = $present - $rideStartTimeStamp;
                            track.durationHTML.innerHTML = Math.floor(track.duration / 3600) + "h" + Math.floor((track.duration / 60) % 60) + "m" + track.duration % 60 + "s";

                            track.fare = track.baseValue + (track.duration / 10) * 0.2;
                            track.fareHTML.innerHTML = track.fare.toFixed(2) + "/=";

                            console.log("duration " + track.duration + " fare " + track.fare);
                            console.log($present);
                            console.log($rideStartTimeStamp);
                            

                        } else { track.error(txt); }})
                        .catch(err => track.error(err));
                    },
                    err => track.error(err)
                    ),

                    // (C) HELPER - ERROR HANDLER
                    error : err => {
                    console.error(err);
                    alert("An error has occured, open the developer's console.");
                    clearInterval(track.timer);
                    }
                };
                
                window.onload = track.init;

                ///////////////////////end of getting location from user and sending it to the server while also updating the map

                function closestPoint(data){
                    // console.log("closest point function called");
                    let closest = 0;
                    let distance = 0;
                    let minDistance = 0;

                    var x = myLoc.getPosition().lat();
                    var y = myLoc.getPosition().lng();
    
                    areas.forEach((area, key) => {
                        distance = Math.sqrt(Math.pow(x - area.position.lat(), 2) + Math.pow(y - area.position.lng(), 2));
                        if (distance < minDistance || minDistance == 0) {
                            minDistance = distance;
                            closest = key;
                        }
                    });
                    
                    //change the icon of the marker with the closest point  
                    for (var j = 0; j < markers.length; j++) {
                        markers[j].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)});
                        markers[j].setLabel(areas[j].label);
                    }
                    markers[closest].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon2.png", labelOrigin: new google.maps.Point(110, 43)});
                    markers[closest].setLabel(areas[closest].label_big);
    
                    map.panTo(markers[closest].getPosition());
    
    
                }

                map.addListener("click", () => {
                    for (var j = 0; j < markers.length; j++) {
                        markers[j].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)});
                        markers[j].setLabel(areas[j].label);
                    }
                });

            

                function endRide(event){
                    if(window.confirm("Are you sure you wish to end the ride?")) {
                        //checks if they're in an area

                        let closest = 0;
                        let distance = 0;
                        let minDistance = 0;

                        var x = myLoc.getPosition().lat();
                        var y = myLoc.getPosition().lng();
        
                        areas.forEach((area, key) => {
                            distance = Math.sqrt(Math.pow(x - area.position.lat(), 2) + Math.pow(y - area.position.lng(), 2));
                            if (distance < minDistance || minDistance == 0) {
                                minDistance = distance;
                                closest = key;
                            }
                        });


                        if(closest<=areas[closest].radius){
                            //create a form including the rideLogID, userID, time_spent and current_fare
                            const endRideDetails = document.createElement('form');

                            const rideLogID = document.createElement('input');
                            rideLogID.type = 'hidden';
                            rideLogID.name = 'rideLogID';
                            rideLogID.value = <?php echo $data['rideLogID'] ?>;

                            const userID = document.createElement('input');
                            userID.type = 'hidden';
                            userID.name = 'userID';
                            userID.value = <?php echo $data['userID'] ?>;

                            const bicycleID = document.createElement('input');
                            bicycleID.type = 'hidden';
                            bicycleID.name = 'bicycleID';
                            bicycleID.value = <?php echo $data['bicycleID'] ?>;

                            const endArea = document.createElement('input');
                            endArea.type = 'hidden';
                            endArea.name = 'endArea';
                            endArea.value = areas[closest].id;

                            const time_spent = document.createElement('input');
                            time_spent.type = 'hidden';
                            time_spent.name = 'time_spent';
                            time_spent.value = track.duration;

                            const current_fare = document.createElement('input');
                            current_fare.type = 'hidden';
                            current_fare.name = 'current_fare';
                            current_fare.value = track.fare.toFixed(2);

                            const payMethod = document.createElement('input');
                            payMethod.type = 'hidden';
                            payMethod.name = 'payMethod';
                            payMethod.value = <?php echo $data['payMethod'] ?>;

                            endRideDetails.appendChild(rideLogID);
                            endRideDetails.appendChild(userID);
                            endRideDetails.appendChild(bicycleID);
                            endRideDetails.appendChild(endArea);
                            endRideDetails.appendChild(time_spent);
                            endRideDetails.appendChild(current_fare);
                            endRideDetails.appendChild(payMethod);

                            //submit the form
                            endRideDetails.method = 'POST';
                            endRideDetails.action = '<?php echo URLROOT; ?>/riders/rideEnded';
                            document.body.appendChild(endRideDetails);
                            endRideDetails.submit();

                        }else{
                            alert("You are not in a docking area, please go to an area to end the ride");
                        }

                    }else{
                        return;
                    }
                }
                
            }

        </script>
    </div>
</body>
</html>