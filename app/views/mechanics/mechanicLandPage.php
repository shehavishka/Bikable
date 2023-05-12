<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/mechanicLandPage.css">
    <title>Mechanic Dashboard</title>
</head>
<body>
    <section class="dashboard--header">
        <div class="dashboard__header--title"><strong>Mechanic's Dashboard</strong></div> 
        <div class="dashboard__header--helpsetting" style="margin-left: 1%;">     
        </div>

        <div class="dashboard__user__detail">
            <div class="user__address">Hello, <?php echo $_SESSION['user_fName'];?></div>
            
            <div class="dropdown_area" style="background-image: url(
                <?php 
                    if($_SESSION['user_picture'] != null){
                        echo URLROOT. "/public/images/profile_pictures/". $_SESSION['user_picture'];
                    }else{
                        echo URLROOT. "/public/images/z_bikableLogo/logo.PNG";
                    }
                ?>);">
                <div class="dashboard__user__dropdown-content">
                    <a href="<?php echo URLROOT ?>/mechanics/profilePage">Profile</a>
                    <!-- <a href="#">Settings</a> -->
                    <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                </div>
            </div>

        </div>  
    </section>

    <section class="upper__section">

        <!-- <div class="upper__section--buttons cardd">
            <div class="admin--button">
                <input type="button" value="MECHANIC" class="btn" onclick="location.href='<?php echo URLROOT;?>/mechanics/mechanic'">
            </div>
            <div class="admin--button">
                <input type="button" value="BICYCLE OWNER" class="btn" onclick="location.href='<?php echo URLROOT;?>/mechanics/bicycleOwner'">
            </div>
            <div class="admin--button">
                <input type="button" value="RIDERS" class="btn" onclick="location.href='<?php echo URLROOT;?>/mechanics/riders'">
            </div> 
        </div> -->

        <!-- report card on the upper section of the display -->
        <div class="upper__section--reports cardd">
            <div class="upper__section__card--title">
                <!-- Reports -->
                <a class = "title" href="<?php echo URLROOT ?>/mechanics/viewAssignedReports">Reports</a>
            </div>
            <div class="upper_section__reports--body">
                <!-- take reports data from the database and display on this table -->
                <table>
                    <tr>
                    <th style="width: 5%;">Report ID</th>
                    <th style="width: 6%;">Problem Title</th>
                    <th style="width: 6%;">Time Logged</th>
                    </tr>

                    <?php foreach($data['dashboard_reports'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->reportID ?></td>
                        <td><?php 
                        // if title is longer than 20 char, cut it and add '...'
                        if(strlen($oneObject->problemTitle) > 18){
                            echo substr($oneObject->problemTitle, 0, 18).'...';
                        }else{
                            echo $oneObject->problemTitle;
                        }
                        ?></td>
                        <td><?php 
                            // echo only the month and day plus the hour and minute of the timestamp
                            echo substr($oneObject->loggedTimestamp, 5, 11);
                        ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <!-- upper section repair log card -->
        <div class="upper__section--repairlog cardd">
            <div class="upper__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/mechanics/repairLogsControl">Active Repair Log</a>
            </div>

            <div class="upper__section__repairlog--body">
                <table>
                    <tr>
                    <th style="width: 5%;">Repair Log ID</th>
                    <th style="width: 6%;">Mechanic ID</th>
                    <th style="width: 6%;">Date In</th>
                    </tr>

                    <?php foreach($data['dashboard_repairLog'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->logID ?></td>
                        <td><?php echo $oneObject->mechanicID ?></td>
                        <td><?php echo $oneObject->dateIn ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="upper__section--bicycles cardd">
            <div class="upper__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/mechanics/bicyclesControl">Bicycles</a>
            </div>
            <div class="upper__section__bicycles--body">
            <table>
                    <tr>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 6%;">Date Put Into Use</th>
                    </tr>

                    <?php foreach($data['dashboard_bicycles'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->datePutInUse ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </section>

    <!-- ***************************************************************************************************************** -->
    <section class="lower__section">
        <!-- lower section map -->
        <!-- <div class="lower_section--map"> -->
        <div id="map-layer"></div>
            <script
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAdJd3svFUpixnG_ebYv6_dDQQHI1QPvlM&callback=initMap"
                async defer>
            </script>
        
            <script type="text/javascript">
                var map;

                function initMap() {
                    var mapLayer = document.getElementById("map-layer");
                    var centerCoordinates = new google.maps.LatLng(6.9100, 79.8800);
                    var defaultOptions = { center: centerCoordinates, zoom: 13.5, mapId: "f58d941242b91036"}

                    map = new google.maps.Map(mapLayer, defaultOptions);
                    
                    const dockAs = [
                    <?php 
                        if(!empty($DAResult)) 
                        {
                            foreach($DAResult as $k=>$v)
                            {   
                    ?>  
                            {
                                position: new google.maps.LatLng(<?php echo $DAResult[$k]["locationLat"]; ?>, <?php echo $DAResult[$k]["locationLong"]; ?>),
                                icon: {url:"<?php echo URLROOT; ?>/public/images/admins/map_icon.png", labelOrigin: new google.maps.Point(43, 18)},
                                label: {text: '<?php echo $DAResult[$k]["currentNoOfBikes"]; ?>', color: "white", fontFamily:"SF Pro Rounded"},
                                labelClass: "marker-position",
                                title: '<?php echo $DAResult[$k]["areaName"]; ?>',
                                clikable: true,
                                url: '<?php echo URLROOT; ?>/mechanics/editDADetails?areaID=<?php echo $DAResult[$k]["areaID"]; ?>',
                                //url: '<php echo URLROOT; ?>/admins/dockingareas',
                            },      
                    <?php
                            }
                        }
                    ?>
                    ];

                    dockAs.forEach(({position, icon, label, labelClass, title, clickable, url}, i) => {
                        // const pinView = new google.maps.Marker({
                        //     glyph: `${i + 1}`,
                        // });

                        const marker = new google.maps.Marker({
                            position,
                            map,
                            icon, label, labelClass, title, clickable
                            //content: pinView.element,
                        });

                        // Add a click listener for each marker
                        marker.addListener('click', function() {
                            window.location = url;
                        });
                    });
                        
                }
            </script>

        <div class="lower_section--statistics">
            <div class="lower__section__card--title">
                <a class = "title" href="<?php echo URLROOT ?>/mechanics/dockingAreas">Docking Areas</a>
            </div>

            <div class="upper_section__reports--body">
                <!-- take reports data from the database and display on this table -->
                <table>
                    <tr>
                    <th style="width: 5%;">Area Name</th>
                    <th style="width: 6%;">Current No. of Bicycles</th>
                    </tr>

                    <?php foreach($data['docking_areas_details'] as $oneObject) : ?>
                    <tr>
                        <td><?php echo $oneObject->areaName ?></td>
                        <td><?php echo $oneObject->currentNoOfBikes ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

    </section>
</body>
</html>