<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/ownerLandPage.css">
    <title>Owner Landpage</title>
</head>
<body>
    <section class="dashboard--header">
        <div class="dashboard__header--title"><strong> Dashboard</strong></div>
        
        <div class="dashboard__header--search">
            <input type="text" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">
            <div class="dashboard__header--searchicon">
                <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
            </div>
        </div>

        <div class="dashboard__header--helpsetting">
            <div class="helpsetting__help">
                <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/question.png" alt="help" class="dashboard__icon">
            </div>
            <div class="helpsetting__setting">
                <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/setting.png" alt="setting" class="dashboard__icon">
            </div>
        </div>

        <div class="dashboard__user__detail">
            <div class="user__address">Hello, <?php echo $_SESSION['user_fName'];?></div>
            <!-- <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/avatar.png" alt="dashboard profile picture" class="imgProperty"> -->
            <!-- <img src="data:image/jpeg;base64,<?php echo $_SESSION['user_picture']; ?>" alt="dashboard profile picture" class="imgProperty"> -->
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_picture']).'" alt="dashboard profile picture" class="imgProperty"'; ?>
        </div>
    </section>


    <section class="upper__section">

        <div class="upper__section--buttons cardd">
            <!-- button class and put button into that classes -->
            <div class="admin--button">
                <input type="button" value="ADMIN" class="btn" onclick="location.href='<?php echo URLROOT;?>/owners/administrator'">
            </div>
            <div class="admin--button">
                <input type="button" value="MECHANIC" class="btn" onclick="location.href='<?php echo URLROOT;?>/owners/mechanic'">
            </div>
            <div class="admin--button">
                <input type="button" value="BICYCLE OWNER" class="btn" onclick="location.href='<?php echo URLROOT;?>/owners/bicycleOwner'">
            </div>
            <div class="admin--button">
                <input type="button" value="RIDERS" class="btn" onclick="location.href='<?php echo URLROOT;?>/owners/riders'">
            </div> 
        </div>

        <!-- report card on the upper section of the display -->
        <div class="upper__section--reports cardd">
            <div class="upper__section__card--title">
                Reports
            </div>
            <div class="upper_section__reports--body">
                <!-- take reports data from the database and display on this table -->
                <table>
                    <tr>
                        <th>Report ID</th>
                        <th>Mechanic ID</th>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                    <tr>
                        <td>2902012</td>
                        <td>200002403065</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- upper section reapir log card -->
        <div class="upper__section--repairlog cardd">
            <div class="upper__section__card--title">
                Repair Log(Active)
            </div>

            <div class="upper__section__repairlog--body">
                <table>
                    <tr>
                        <th>Log ID</th>
                        <th>Bicyle ID</th>
                        <th>Date in</th>
                    </tr>

                    <tr>
                        <td>M32465</td>
                        <td>34156D</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>F35325</td>
                        <td>26134F</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>J31535</td>
                        <td>34524G</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>L78975</td>
                        <td>25236D</td>
                        <td>2022.11.11</td>
                    </tr>

                    <tr>
                        <td>F35325</td>
                        <td>26134F</td>
                        <td>2022.11.11</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="upper__section--bicycles cardd">
            <div class="upper__section__card--title">
                Bicycles
            </div>
            <div class="upper__section__bicycles--body">
                <table>
                    <tr>
                        <th>Bicycle ID</th>
                        <th>Frame</th>
                        <th>Status</th>
                    </tr>

                    <tr>
                        <td>34156D</td>
                        <td>L</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>34152D</td>
                        <td>L</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>S</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>S</td>
                        <td>Active</td>
                    </tr>

                    <tr>
                        <td>43214Q</td>
                        <td>M</td>
                        <td>Inactive</td>
                    </tr>

                </table>
            </div>
        </div>
    </section>

    <!-- ***************************************************************************************************************** -->
    <section class="lower__section">
        <div class="lower_section--map" id="map-layer">
            <!-- <h1>MAP IS HERE</h1> -->
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdJd3svFUpixnG_ebYv6_dDQQHI1QPvlM&callback=initMap" async defer>
            </script>
        
            <script type="text/javascript">
                var map;

                function initMap(){
                    var mapLayer = document.getElementById("map-layer");
                    var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                    var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}

                    map = new google.maps.Map(mapLayer, defaultOptions);
                    
                    <?php foreach($data['docking_areas_details'] as $oneObject) : ?>

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
                        
                }
            </script>
        </div>

        <div class="lower_section--statistics">
            <div class="lower__section__card--title">
                Statistics
            </div>

            <div class="lower__section__statistics--body">
                <div class="static__image">
                    <!-- <h2>Image here</h2> -->
                </div>
                <div class="static__graph">
                    <!-- <h2>Static graph here</h2> -->
                </div>
            </div>
        </div>

    </section>
</body>
</html>