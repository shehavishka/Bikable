<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/rides.css">
    <title>Rides</title>
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
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Rides</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Area" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div> -->
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 8%;">Rider ID</th>
                    <th style="width: 8%;">Bicycle ID</th>
                    <th style="width: 12%;">Start: <br>Area ID</th>
                    <th style="width: 12%;">End: <br>Area ID</th>
                    <th style="width: 7%;">Date & Start: <br> Time</th>
                    <th style="width: 7%;">Date & End:<br>Time</th>
                    <th style="width: 4%;">Total: <br>KM</th>
                    <th style="width: 4%;">Fare: <br>LKR</th>
                    <th style="width: 3%;"></th>

                </tr>

                <!-- sample template data -->
                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>3425454</td>
                    <td>24524F</td>
                    <td>COL4B <br>
                        <small>6.8962° N, 79.8571° E</small></td>
                    <td>COL2A <br>
                        <small>25.3744° S, 49.1933° W</small></td>
                    <td>2023.03.01</td>
                    <td>10:26</td>
                    <td>13:30</td>
                    <td>8</td>
                    <td>700</td>
                    <td> -->
                        <!-- update icon svg format -->
                        <!-- <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->

                <?php foreach($data['rides_details'] as $rideOne) : ?>
                    <tr style="height: 2.5rem;">
                        <td></td>
                        <td><?php echo $rideOne->riderID ?></td>
                        <td><?php echo $rideOne->bicycleID ?></td>
                        <td><?php echo $rideOne->startAreaID ?></td>
                        <td><?php echo $rideOne->endAreaID ?></td>
                        <td><?php echo $rideOne->rideStartTimeStamp ?></td>
                        <td><?php
                            if($rideOne->rideEndTimeStamp == null){
                                echo "Active";
                            }else{
                                echo $rideOne->rideEndTimeStamp;
                            }                        
                        ?></td>
                        <td><?php echo $rideOne->distanceTravelled ?></td>
                        <td><?php echo $rideOne->fare ?></td>


                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </section>



</body>
</html>