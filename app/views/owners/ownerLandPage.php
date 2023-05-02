<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/ownerLandPage.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="<?php echo URLROOT; ?>/owners/landToErrorPage"><img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/question.png" alt="help" class="dashboard__icon"></a>
                
            </div>
            <div class="helpsetting__setting">
                <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/setting.png" alt="setting" class="dashboard__icon">
            </div>
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
                        <a href="<?php echo URLROOT ?>/owners/ownerViewsHisOwnProfile">Profile</a>
                        <!-- <a href="#">Settings</a> -->
                        <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                    </div>
            </div>

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
            <a href="<?php echo URLROOT ?>/owners/reportsControl" style="text-decoration:none;color:black" class="anchor--card">
                <div class="upper__section--reports cardd">
                        <div class="upper__section__card--title" style="text-decoration:none">
                            Reports
                        </div>
                    <div class="upper_section__reports--body">
                        <!-- take reports data from the database and display on this table -->
                        <table>
                            <tr>
                                <th>Report ID</th>
                                <th>Mechanic ID</th>
                            </tr>

                            <?php 
                                shuffle($data['reportID_assignedMechanicID_details']); // shuffle the array
                                foreach(array_slice($data['reportID_assignedMechanicID_details'], 0, 5) as $reportRow) : // select first five elements
                            ?>
                                <tr style="height: .5rem;">
                                    <td><?php echo $reportRow->reportID ?></td>
                                    <td><?php echo $reportRow->assignedMechanic ? $reportRow->assignedMechanic : "Not Assigned" ?></td>
                                </tr>
                            <?php endforeach; ?>

                        </table>
                    </div>
                </div>
            </a>

        <!-- upper section reapir log card -->
        <a href="<?php echo URLROOT ?>/owners/addNewRepairLog" style="text-decoration:none;color:black">
            <div class="upper__section--repairlog cardd">
                <div class="upper__section__card--title">
                    Repair Log(Active)
                </div>

                <div class="upper__section__repairlog--body" style="height: 11rem;">
                    <table>
                        <tr>
                            <th>Log ID</th>
                            <th>Bicyle ID</th>
                            <th>Date in</th>
                        </tr>
                        
                        <?php 
                                shuffle($data['repair_log_details']); // shuffle the array
                                foreach(array_slice($data['repair_log_details'], 0, 5) as $reportRow) : // select first five elements
                        ?>
                                <tr style="height: .5rem;">
                                    <td><?php echo $reportRow->logID ?></td>
                                    <td><?php echo $reportRow->bicycleID?></td>
                                    <td><?php echo $reportRow->dateIn?></td>
                                </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </a>

        <a href="<?php echo URLROOT ?>/owners/bicyclesControl" style="text-decoration:none;color:black">
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
                        
                        <?php 
                            shuffle($data['bicycles_details']); // shuffle the array
                            foreach(array_slice($data['bicycles_details'], 0, 5) as $bicycleRow) : // select first five elements
                        ?>
                        <tr>
                            <td><?php echo $bicycleRow->bicycleID ?></td>
                            <td><?php echo $bicycleRow->frameSize ?></td>
                            <td><?php echo $bicycleRow->status ?></td>
                        </tr>
                        <?php endforeach; ?>

                    </table>
                </div>
            </div>
        </a>
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

        <div class="lower_section_statistics--doughnut">
            <div class="lower__section__card--title">
                Bike Inventory Status
            </div>
            <!-- DOUGHNUT CHART -->
            <div class="lower__section__card--doughnuts">
                <canvas id="myChart" width="20" height="20"></canvas>
            </div>
            <script>
                    const data1 = {
                        labels: [
                            'Occupied Bikes',
                            'Vacant Bikes',
                            'Bikes in Repair'
                        ],
                        datasets: [{
                            label: 'Bikes',
                            data: [300, 50, 100],
                            backgroundColor: [
                                'rgb(28, 28, 28)',
                                'rgb(158, 158, 157)',
                                'rgb(222, 222, 222)'
                            ],
                            hoverOffset: 4
                        }]
                    };

                    const config = {
                        type: 'doughnut',
                        data: data1,
                        options: {
                            cutout: '70%',
                            fontSize: 12,
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'right',
                                    align: 'center',
                                    labels: {
                                        font: {
                                            family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                                            size: 10,
                                        },
                                        padding: 10,
                                        boxWidth: 80,
                                        usePointStyle: true
                                    }
                                },
                                // datalabels: {
                                //     color: '#fff',
                                //     font: {
                                //         size: 12,
                                //     },
                                //     formatter: (value, context) => {
                                //         const total = context.chart.data.datasets[0].data.reduce((acc, val) => acc + val, 0);
                                //         const percentage = Math.round((value / total) * 100);
                                //         return `${value} (${percentage}%)`;
                                //     },
                                // },
                                
                            },
                            // scales: {
                            //     y: {
                            //         beginAtZero: true,
                            //     },
                            // },
                        },
                    };
                    var myChart = new Chart(
                        document.getElementById('myChart'),
                        config
                    );
            </script>            
        </div>

        <div class="lower_section_statistics--bars">
            <div class="lower__section__card--title">
                Bike Availability Trend
            </div>
            <div class="lower__section__card--bars">
                <canvas id="myLine" width="20" height="20"></canvas>
            </div>  
            <script>
                const data2 = {
                        labels: [
                            "Mon","Tue","Wed","Thu","Fri","Sat","Sun"
                        ],
                        datasets: [{
                                label: "Vacant Bikes",
                                data: [180,200,150,120,100,150,200],
                                borderColor: "rgba(255, 99, 132, 1)",
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                fill: true,
                                tension: 0.1,
                            },
                            {
                                label: "Occupied Bikes",
                                data: [100,80,120,150,200,150,100],
                                borderColor: "rgba(54, 162, 235, 1)",
                                backgroundColor: "rgba(54, 162, 235, 0.2)",
                                fill: true,
                                tension: 0.4,
                            },
                        ]
                };

                    const config2 = {
                        type: 'line',
                        data: data2,
                        options: {
                            plugins: {
                                legend: {
                                    position: "bottom",
                                },
                            },
                            scales: {
                                x: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: "Days",
                                    },
                                },
                                y: {
                                    display: true,
                                    title: {
                                        display: true,
                                        text: "Number of Bikes",
                                    },
                                    suggestedMin: 50,
                                },
                            },
                        },
                    };
                    var myChart = new Chart(
                        document.getElementById('myLine'),
                        config2
                );
            </script>
        </div>
    </section>
</body>
</html>