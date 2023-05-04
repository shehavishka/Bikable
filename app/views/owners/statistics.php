<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/statistics.css">
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
            <div class="data__count__area--totalRiders">
                <div class="data__count__area--totalRiders--value">
                    100
                </div>
                <div class="data__count__area--totalRiders--title">
                    Total Riders
                </div>
            </div>
            <div class="data__count__area--totalBikes">
                <div class="data__count__area--totalBikes--value">
                    200
                </div>
                <div class="data__count__area--totalBikes--title">
                    Total Bikes
                </div>
            </div>
            <div class="data__count__area--totalDockingAreas">
                <div class="data__count__area--totalDockingAreas--value">
                    10
                </div>
                <div class="data__count__area--totalDockingAreas--title">
                    Total Docking Areas
                </div>
            </div>
            <div class="data__count__area--activeReports">
                <div class="data__count__area--activeReports--value">
                    13
                </div>
                <div class="data__count__area--activeReports--title">
                    Active Reports
                </div>
            </div>
        </div>

        <section class="graphs-Area">
            <div class="top_left-graph">
                <h1>Graph 1</h1>
            </div>
            <div class="top_middle-graph">
                <h1>Graph 2</h1>
            </div>
            <div class="top_right-graph">
                <h1>Graph 3</h1>
            </div>
            <div class="bottom_left-graph">
                <h1>Graph 4</h1>
            </div>
            <div class="bottom_middle-graph">
                <h1>Graph 5</h1>
            </div>
            <div class="bottom_right-graph">
                <h1>Graph 6</h1>
            </div>
        </section>
    </section>





</body>
</html>