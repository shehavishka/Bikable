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
                <div class="data__area__top--date">
                    <label for="start-date">From</label>
                    <input type="date" id="start-date">

                    <label for="end-date">To</label>
                    <input type="date" id="end-date">
                </div>
            </div>
            <div class="data__area__top--fare--rate--button">
                <div class="data__area__top__fare__rate">
                    <div class="data__area__top__fare">
                        Fare Base Value : 150/=
                    </div>
                    <div class="data__area__top__rate">
                        Rate per seconds : 0.2/=
                    </div>
                </div>
                <div class="data__area--top--button">
                    
                    <input type="button" value="submit">
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
                    200
                </div>
                <div class="data__count__area--totalBikes--title">
                    Total Bikes
                </div>
            </div>
            <div class="data__count__area--totalDockingAreas cardd">
                <div class="data__count__area--totalDockingAreas--value">
                    10
                </div>
                <div class="data__count__area--totalDockingAreas--title">
                    Total Docking Areas
                </div>
            </div>
            <div class="data__count__area--activeReports cardd">
                <div class="data__count__area--activeReports--value">
                    13
                </div>
                <div class="data__count__area--activeReports--title">
                    Active Reports
                </div>
            </div>
        </div>

        <section class="graphs-Area1">
            <div class="top_left-g">
                <div class="lower__section__card--title" styles="margin-bottom: -10px;">
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
                                        position: 'top',
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

            <div class="top_righ-g">
                <div class="lower__section__card--title" style="margin-top: 5px; margin-left: 7%">
                    Bike Availability Trend
                </div>
                <div class="lower__section__card--bars" style="margin-top: 5px;">
                    <canvas id="myLine" width="50" height="20"></canvas>
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