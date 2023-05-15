<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/statistics.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Statistics</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <!-- <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Statistics</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add User" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>
        </div> -->

        <div class="data__area--top">
            <div class="data__area__top--title--date">
                <div class="data__area__top--title">
                    Statistics
                </div>
                <!-- <div class="data__area__top--date">
                    <label for="start-date">From</label>
                    <input type="date" id="start-date">

                    <label for="end-date">To</label>
                    <input type="date" id="end-date">
                </div> -->
            </div>
            <div class="data__area__top--fare--rate--button">
                <div class="data__area__top__fare__rate">
                    <div class="data__area__top__fare">
                        Fare Base Value : Rs. <?php echo $data['fare'] ?> /=
                    </div>
                    <div class="data__area__top__rate">
                        Rate per seconds : Rs. <?php echo $data['rate'] ?> /=
                    </div>
                </div>
                <div class="data__area--top--button">
                        <button id="open-form-btn">Edit</button>

                        <div id="form-popup" style="display:none;">
                            <form id="rental-form" action="<?php echo URLROOT;?>/owners/setFareAndRate" method="post">
                                <label for="fare">Fare:</label>
                                <input type="text" id="fare" name="fare" required>

                                <label for="rate">Rate:</label>
                                <input type="text" id="rate" name="rate" required>

                                <button type="submit" id="submit-btn">Submit</button>
                                <button type="button" id="cancel-btn">Cancel</button>
                            </form>
                        </div>

                        <script>
                            var openFormBtn = document.getElementById('open-form-btn');
                            var formPopup = document.getElementById('form-popup');
                            var cancelBtn = document.getElementById('cancel-btn');
                            
                            openFormBtn.addEventListener('click', function() {
                                formPopup.style.display = 'block';
                            });
                            
                            cancelBtn.addEventListener('click', function() {
                                formPopup.style.display = 'none';
                            });
                            
                            var rentalForm = document.getElementById('rental-form');
                            var submitBtn = document.getElementById('submit-btn');
                            
                            submitBtn.addEventListener('click', function() {
                                // Validate form fields here
                                
                                rentalForm.submit();
                            });
                        </script>
                </div>
            </div>
        </div>



        <div class="data__count--area">
            <div class="data__count__area--totalRiders cardd">
                <div class="data__count__area--totalRiders--value">
                    <?php echo $data['totalRiders']; ?>
                </div>
                <div class="data__count__area--totalRiders--title">
                    Total Riders
                </div>
            </div>
            <div class="data__count__area--totalBikes cardd">
                <div class="data__count__area--totalBikes--value">
                    <?php echo $data['totalBikes']; ?>
                </div>
                <div class="data__count__area--totalBikes--title">
                    Total Bikes
                </div>
            </div>
            <div class="data__count__area--totalDockingAreas cardd">
                <div class="data__count__area--totalDockingAreas--value">
                    <?php echo $data['totalDockingAreas']; ?>
                </div>
                <div class="data__count__area--totalDockingAreas--title">
                    Total Docking Areas
                </div>
            </div>
            <div class="data__count__area--activeReports cardd">
                <div class="data__count__area--activeReports--value">
                    <?php echo $data['activeReports']; ?>
                </div>
                <div class="data__count__area--activeReports--title">
                    Active Reports
                </div>
            </div>
        </div>

        <section class="graphs-Area1">
            <div class="top_left-g">
                <div class="data__count__area--totalDockingAreas cardd cardd_custom">
                    <div class="data__count__area--totalDockingAreas--value">
                        <?php echo $data['administratorCount']; ?>
                    </div>
                    <div class="data__count__area--totalDockingAreas--title">
                        Total Administrators
                    </div>
                </div>

                <div class="data__count__area--totalDockingAreas cardd cardd_custom">
                    <div class="data__count__area--totalDockingAreas--value">
                        <?php echo $data['mechanicsCount']; ?>
                    </div>
                    <div class="data__count__area--totalDockingAreas--title">
                        Total Mechanics
                    </div>
                </div>
            </div>

            <div class="top_righ-g">
                <div class="lower__section__card--title" style="margin-top: 5px; margin-left: 7%">
                    Reports Trend
                </div>
                <div class="lower__section__card--bars" style="margin-top: 5px;">
                    <canvas id="myLine" width="50" height="20"></canvas>
                </div>  
                <script>
                    const data2 = {
                            labels: <?php echo json_encode($data["xDate"]); ?>,
                            datasets: [{
                                    label: "Bike Reports",
                                    data: <?php echo json_encode($data["bikeReports"]); ?>,
                                    borderColor: "rgba(255, 99, 132, 1)",
                                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                                    fill: true,
                                    tension: 0.1,
                                },
                                {
                                    label: "Area Reports",
                                    data: <?php echo json_encode($data["areaReports"]); ?>,
                                    borderColor: "rgba(54, 162, 235, 1)",
                                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                                    fill: true,
                                    tension: 0.1,
                                },
                                {
                                    label: "Accident Reports",
                                    data: <?php echo json_encode($data["accidentReports"]); ?>,
                                    borderColor: "rgba(153, 102, 255, 1)",
                                    backgroundColor: "rgba(153, 102, 255, 0.2)",
                                    fill: true,
                                    tension: 0.1,
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
            <!-- <div class="bottom_left-g">
                <h1>Graph 4</h1>
            </div>
            <div class="bottom_middle-g">
                <h1>Graph 5</h1>
            </div>
            <div class="bottom_right-g">
                <h1>Graph 6</h1>
            </div> -->
        </section>
    </section>





</body>
</html>