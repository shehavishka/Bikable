<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/riderLandPage.css">
    <title>Rider Landpage</title>
</head>
<body>
    <?php require APPROOT . '/views/inc/header-rider.php'; ?>

    <div class="floating-panel" id="floating-panel">
        <div id="welcome_message">
            <!-- logged in user's name -->
            <h1>Hi <?php echo $_SESSION['user_fName']; ?></h1>
            <div id="sub-text">
                Ride a bike
                <!-- <div id="content">Hello world!</div> -->
            </div>
        </div>
        
        <div id="scan_button">
            <a href="<?php echo URLROOT;?>/riders/scanQR"><img src="<?php echo URLROOT;?>/public/images/general/scanIcon1.png" alt="scan"></a>
        </div>

        <div class="welcome_message area_details" id="area_details">
            <div class="area_name">
                <h1 id="area_name" style="hidden:true">Joseph's Lane</h1>
            </div>

            <div class="info">
                <div class="info_1">
                    <div class="info_number" id="available_bikes">
                        0
                    </div>                    
                    <div class="info_title">
                        Available Bikes
                    </div>
                </div>
                <div class="vl"></div>
                <div class="info_2" id="distance">
                    <div class="info_number" id="distance_to">
                        0
                    </div>
                    <div class="info_title">
                        Distance
                    </div>
                </div>
            </div>

            <!-- div for two buttons, cross and directions -->
            <div class="action_buttons">
                <div class="cross">
                <img src="<?php echo URLROOT;?>/public/images/general/crossIcon1.png" alt="cancel" >
                </div>

                <div class="directions">
                    <div>
                        Directions
                    </div>
                    <div>
                        <img src="<?php echo URLROOT;?>/public/images/general/startIcon1.png" alt="directions">
                    </div>
                </div>
            </div>

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
                let infoWindowArea = new google.maps.InfoWindow();

                let panel = document.getElementById("floating-panel");
                let welcomeMessage = document.getElementById("welcome_message");
                let areaDetails = document.getElementById("area_details");

                let areaName = document.getElementById("area_name");
                let availableBikes = document.getElementById("available_bikes");
                let distance = document.getElementById("distance");
                let distance_to = document.getElementById("distance_to");
                
                var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}
                
                const map = new google.maps.Map(mapLayer, defaultOptions);
                var markers = [];

                const areas = [
                    <?php foreach($data['mapDetails'] as $oneObject) : ?>
                        {
                            //position: {lat: <?php echo $oneObject->locationLat; ?>, long: <?php echo $oneObject->locationLong; ?>},
                            id: <?php echo $oneObject->areaID; ?>,
                            position: new google.maps.LatLng(<?php echo $oneObject->locationLat; ?>, <?php echo $oneObject->locationLong; ?>),
                            //type: "info",
                            title: "<?php echo $oneObject->areaName; ?>",
                            label: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                            label_big: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded", fontSize: "45px"},
                            content: "<?php echo $oneObject->areaName; ?>",
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

                    
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {;
                            for (var j = 0; j < markers.length; j++) {
                            markers[j].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)});
                            markers[j].setLabel(areas[j].label);
                            }
                            marker.setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon2.png", labelOrigin: new google.maps.Point(110, 43)});
                            marker.setLabel(label_big);

                            map.panTo(marker.getPosition());
                            panelExpand(id);
                        };
                    })(marker, i));
                    markers.push(marker);

                });

                map.addListener("click", () => {
                    for (var j = 0; j < markers.length; j++) {
                        markers[j].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)});
                        markers[j].setLabel(areas[j].label);
                    }

                    panelContract();
                });

                function getCurrentPosition() {
                    return new Promise(function(resolve, reject) {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
                                var pos = [position.coords.latitude, position.coords.longitude];
                                resolve(pos);
                            }, function(error) {
                                reject(error);
                            });
                        } else {
                            reject("Geolocation is not supported by this browser.");
                        }
                    });
                }

                function panelExpand(id) {
                    console.log("panel expand");
                    console.log(id);
                    
                    // Get the user's current position using a Promise
                    getCurrentPosition().then(function(pos) {
                        // Assign the pos array to the xhttp request URL
                        var xhttp;    
                        if (id == "") {
                            areaName.innerHTML = "Error";
                            availableBikes.innerHTML = "0";
                            distance.innerHTML = "0";
                            return;
                        }

                        xhttp = new XMLHttpRequest();

                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                console.log(this.responseText);
                                var response = JSON.parse(this.responseText);

                                if (response['areaName'] != null){
                                    if(response['areaName'].length > 11){
                                        areaName.innerHTML = response['areaName'].substring(0, 11) + "...";
                                    }else{
                                        areaName.innerHTML = response['areaName'];
                                    }
                                }
                                else{
                                    areaName.innerHTML = "Not Found";
                                }

                                if (response['currentNoOfBikes'] != null){
                                    availableBikes.innerHTML = response['currentNoOfBikes'];
                                }
                                else{
                                    availableBikes.innerHTML = "-";
                                }

                                if(response['distance'] != null){
                                    distance_to.innerHTML = response['distance'] + " km";
                                }
                                else{
                                    distance_to.innerHTML = "-";
                                }
                            }
                        };

                        xhttp.open("GET", "<?php echo URLROOT; ?>/riders/getMapDADetails?q="+id+"&lat="+pos[0]+"&long="+pos[1], true);
                        xhttp.send();

                        //animation and showing the area details
                        panel.classList.add("expanded");
                        welcomeMessage.style.visibility = "hidden";
                        area_details.style.display = "block";
                    }).catch(function(error) {
                        console.error(error);
                    });
                }


                function panelContract(){
                   //console.log("panel contract");
                    panel.classList.remove("expanded");

                    welcomeMessage.style.visibility = "visible";
                    area_details.style.display = "none";
                }

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                    (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent("Location found.");
                    infoWindow.open(map);
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
            }
        </script>
    </div>
</body>
</html>