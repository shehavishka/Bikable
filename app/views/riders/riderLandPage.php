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
    <div id="floating-panel">
        <!-- logged in user's name -->
        <div id="welcome_message">
            <h1>Hi <?php echo $_SESSION['user_fName']; ?></h1>
            <div id="sub-text">
                Ride a bike
                <!-- <div id="content">Hello world!</div> -->
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
                let infoWindowArea = new google.maps.InfoWindow();
                
                var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}
                
                const map = new google.maps.Map(mapLayer, defaultOptions);
                var markers = [];

                const areas = [
                    <?php foreach($data['mapDetails'] as $oneObject) : ?>
                        {
                            //position: {lat: <?php echo $oneObject->locationLat; ?>, long: <?php echo $oneObject->locationLong; ?>},
                            position: new google.maps.LatLng(<?php echo $oneObject->locationLat; ?>, <?php echo $oneObject->locationLong; ?>),
                            //type: "info",
                            title: "<?php echo $oneObject->areaName; ?>",
                            label: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                            label_big: {text: '<?php echo $oneObject->currentNoOfBikes; ?>', color: "white", fontFamily:"SF Pro Rounded", fontSize: "45px"},
                            content: "<?php echo $oneObject->areaName; ?>",
                        },
                    <?php endforeach; ?>
                ];
                
                areas.forEach(({ position, title, label, label_big }, i) => {
                    // const pinView = new google.maps.marker.PinView({
                    //     glyph: `${i + 1}`,
                    // });

                    const marker = new google.maps.Marker({
                        position,
                        map,
                        title,
                        icon: {url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                        label,
                        labelClass: "marker-position",
                        // content: pinView.element,
                    });

                    // marker.addListener("click", ({ domEvent, latLng }) => {
                    // marker.setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon1.png"});
                    // // const { target } = domEvent;

                    // // infoWindow.close();
                    // // infoWindow.setContent(marker.title);
                    // // infoWindow.open(marker.map, marker);
                    // });
                    
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            // infoWindow.setContent(areas[i][0], areas[i][6]);
                            // infoWindow.open(map, marker);
                            for (var j = 0; j < markers.length; j++) {
                            markers[j].setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)});
                            markers[j].setLabel(areas[j].label);
                            }
                            marker.setIcon({url:"<?php echo URLROOT; ?>/public/images/admins/map_icon2.png", labelOrigin: new google.maps.Point(110, 43)});
                            marker.setLabel(label_big);
                        };
                    })(marker, i));
                    markers.push(marker);

                });


                // if (navigator.geolocation) {
                //     navigator.geolocation.getCurrentPosition(
                //     (position) => {
                //     const pos = {
                //         lat: position.coords.latitude,
                //         lng: position.coords.longitude,
                //     };

                //     infoWindow.setPosition(pos);
                //     infoWindow.setContent("Location found.");
                //     infoWindow.open(map);
                //     map.setCenter(pos);
                //     },
                //     () => {
                //     handleLocationError(true, infoWindow, map.getCenter());
                //     }
                // );
                // } else {
                //     // Browser doesn't support Geolocation
                //     handleLocationError(false, infoWindow, map.getCenter());
                // }

                // function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                //     infoWindow.setPosition(pos);
                //     infoWindow.setContent(
                //         browserHasGeolocation
                //         ? "Error: The Geolocation service failed."
                //         : "Error: Your browser doesn't support geolocation."
                //     );
                //     infoWindow.open(map);
                // }

                window.initMap = initMap;
                    
            }
        </script>
    </div>
</body>
</html>