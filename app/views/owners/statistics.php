<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="statistics.css">
    <title>Admin Detail</title>
</head>
<body>
    <!-- finalized side bar -->
    <section class="sidebar">
        <div class="viewData">
            <div class="sidebar--logo">
                <div class="sidebar--logo--img">
                    <img src="images/bikableLogo/logo.PNG" alt="">
                </div>
            </div>
            <div class="sidebar__detail">
                <div class="detail detail__dashboard">
                    Dashboard
                </div>
                <hr>
                <div class="detail detail__users">
                    <div class="detail__users--title">
                        Users
                    </div>
                    <div class="detail__users--submenu">
                        <div class="submenu users__submenu--mechanic">
                            Mechanic
                        </div>
                        <div class="submenu users__submenu--riders">
                            Riders
                        </div>
                        <div class="submenu users__submenu--bicycleOwners">
                            Bicycle Owners
                        </div>
                        <div class="submenu users__submenu--administrators">
                            Administrators
                        </div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__repairLog">
                    <div class="detail__repairlog--title">
                        Repair Log
                    </div>
                </div>
                <hr>
                <div class="detail detail__dockingAreas">
                    <div class="detail__dockingAreas--title">
                        Docking Areas
                    </div>
                </div>
                <hr>
                <div class="detail detail__bicycles">
                    <div class="detail__bicycles--title">
                        Bicycles
                    </div>
                </div>
                <hr>
                <div class="detail detail__rides">
                    <div class="detail__rides--title">
                        Rides
                    </div>
                </div>
                <hr>
                <div class="detail detail__reports">
                    <div class="detail__reports--title">
                        Reports
                    </div>
                    <div class="detail__reports--submenu">
                        <div class="submenu reports__submenu--accidentReport">
                            Accident Reports
                        </div>
                        <div class="submenu users__submenu--bikeComplaintReport">
                            Bike Complaint Reports
                        </div>
                        <div class="submenu users__submenu--dockingAreaReport">
                            Docking Area Reports
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <section class="dashboard--header">
            <!-- <div class="dashboard__header--title"><strong> Dashboard</strong></div>
             -->
            <div class="dashboard__header--search">
                <input type="text" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">
                <div class="dashboard__header--searchicon">
                    <img src="images/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
                </div>
            </div>
    
            <div class="dashboard__header--helpsetting">
                <div class="helpsetting__help">
                    <img src="images/dashboardIcons/question.png" alt="help" class="dashboard__icon">
                </div>
                <div class="helpsetting__setting">
                    <img src="images/dashboardIcons/setting.png" alt="setting" class="dashboard__icon">
                </div>
            </div>
    
            <div class="dashboard__user__detail">
                <div class="user__address">Hello, Shehaan</div>
                <img src="images/avatar.png" alt="dashboard profile picture" class="imgProperty">
            </div>      
        </section>

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