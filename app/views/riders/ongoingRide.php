<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/riderLandPage.css">
    <title>Ongoing Ride</title>
</head>
<body>
    <div id="floating-panel">
        <!-- logged in user's name -->
        <div id="welcome_message">
            <h1>Hi <?php echo $_SESSION['user_fName']; ?></h1>
            <div id="sub-text">
                Ride a bike
            </div>
        </div>

        <div id="scan_button">
            <a href="<?php echo URLROOT;?>/riders/scanQR"><img src="<?php echo URLROOT;?>/public/images/general/scanIcon1.png" alt="scan"></a>
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
                
                <?php foreach($data['mapDetails'] as $oneObject) : ?>

                            var latitude = <?php echo $oneObject->locationLat; ?>;
                            var longitude = <?php echo $oneObject->locationLong; ?>

                            new google.maps.Marker({
                                position: new google.maps.LatLng(latitude, longitude),
                                map: map,
                                icon: {url:"<?php echo URLROOT; ?>/public/images/owners/landPageImages/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                                label: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                                labelClass: "marker-position",
                                title: '<?php echo $oneObject->areaName; ?>'
                            });
                <?php endforeach; ?>

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