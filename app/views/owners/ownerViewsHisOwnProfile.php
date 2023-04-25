<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="ownerViewHisOwnProfile.css">
    <title>Owner Profile</title>
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
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">User Profile</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Edit" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Suspend" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <section class="data__area">
            <div class="left--side">
                <div class="profile__picture--card">
                    <div> 
                        <h1>Image</h1>
                    </div>
                    <div class="user_history">
                        <div class="user_detail_x">
                            <label>User ID</label>
                            <div class="user__data">
                                12582
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Last Logged In</label>
                            <div class="user__data">
                                2022/10/10
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Registered Date</label>
                            <div class="user__data">
                                2020/10/24
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
            <div class="right--side">
                <div class="detail__view--card">
                    <!-- <div class="generalInformation"><strong><h2>General Information</h2></strong></div> -->
                    <div class="user__detail">
                        <div class="user_detail_x">
                            <label>Name</label>
                            <div class="user__name">
                                Deshan Perera
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Mobile Number</label>
                            <div class="user__data">
                                0771691525
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Email</label>
                            <div class="user__data">
                                deshan@gmail.com
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>NIC</label>
                            <div class="user__data">
                                200001558692
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Status</label>
                            <div class="user__data">
                                Active
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Role</label>
                            <div class="user__data">
                                Mechanic
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="button__area">
                    <form action="" method="post">
                        <input type="hidden" name="userIdentity" value="">
                        <input type="submit" value="Suspend" class="btn">
                    </form>
                </div>
            </div>
        </section>
            
        </div>
    </section>
</body>
</html>