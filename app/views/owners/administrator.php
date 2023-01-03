<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/administrator.css">
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
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Administrators</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add User" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 13%;">Username</th>
                    <th style="width: 10%;">UserID</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 15%;">NIC</th>
                    <th style="width: 10%;">Role</th>
                    <th style="width: 5%;"></th>

                </tr>

                <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>Shehaan Avishka</td>
                    <td>1238524</td>
                    <td>Inactive</td>
                    <td>OwnerShehaan@gmail.com</td>
                    <td>200002403065</td>
                    <td>Admin</td>
                    <td>
                        <!-- update icon svg format -->
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr>
                
                <tr>
                    <td><input type="checkbox"></td>
                    <td>Shehaan Avishka</td>
                    <td>1238524</td>
                    <td>Inactive</td>
                    <td>OwnerShehaan@gmail.com</td>
                    <td>200002403065</td>
                    <td>Admin</td>
                    <td>
                        <!-- update icon svg format -->
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr>



                <tr>
                    <td><input type="checkbox"></td>
                    <td>Shehaan Avishka</td>
                    <td>1238524</td>
                    <td>Inactive</td>
                    <td>OwnerShehaan@gmail.com</td>
                    <td>200002403065</td>
                    <td>Admin</td>
                    <td>
                        <!-- update icon svg format -->
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr>


                <tr>
                    <td><input type="checkbox"></td>
                    <td>Shehaan Avishka</td>
                    <td>1238524</td>
                    <td>Inactive</td>
                    <td>OwnerShehaan@gmail.com</td>
                    <td>200002403065</td>
                    <td>Admin</td>
                    <td>
                        <!-- update icon svg format -->
                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr>




                <!-- <?php foreach($data['admin_details'] as $oneAdmin) : ?>
                    <tr>
                        <td><?php echo $oneAdmin->first_name ?></td>
                        <td><?php echo $oneAdmin->last_name ?></td>
                        <td><?php echo $oneAdmin->email ?></td>
                        <td><?php echo $oneAdmin->nic ?></td>
                        <td>
                            <?php 
                                if($oneAdmin->status == "1"){
                                    echo "Inactive";
                                }else{
                                    echo "Deactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneAdmin->role ?></td>
                    </tr>
                <?php endforeach; ?> -->

            </table>
        </div>
    </section>



</body>
</html>