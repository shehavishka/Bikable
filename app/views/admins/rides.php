<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/rides.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Rides</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Rides</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/admins/addAdministrator'">
                </div> -->
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <!-- <th style="width: 2%;"></th> -->
                    <th style="width: 5%;">Rider ID</th>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 6%;">Status</th>
                    <th style="width: 7%;">Started At</th>
                    <th style="width: 7%;">Ended At</th>
                    <th style="width: 5%;">Fare</th>
                    <th style="width: 6%;">Travelled Time</th>
                    <th style="width: 5%;">Start Area</th>
                    <th style="width: 5%;">End Area</th>
                    <!-- <th style="width: 6%;">Payment Method</th> -->
                    <th style="width: 10%;">Current Location</th>

                    <?php foreach($data['ride_details'] as $oneObject) : ?>
                    <tr>
                        <!-- <td><input type="checkbox"></td> -->
                        <td><?php echo $oneObject->riderID ?></td>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 1){
                                    echo "In progress";
                                }else{
                                    echo "Complete";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject->rideStartTimeStamp ?></td>
                        <td><?php echo $oneObject->rideEndTimeStamp ?></td>
                        <td><?php echo $oneObject->fare ?>/=</td>
                        <td><?php 
                                    $hours = floor($oneObject->timeTravelled / 3600);
                                    $minutes = floor(($oneObject->timeTravelled / 60) % 60);
                                    $seconds = $oneObject->timeTravelled % 60;

                                    echo $hours . 'h' . $minutes . 'm' . $seconds . 's'; 
                                ?></td>
                        <td><?php 
                                foreach($data['map_details'] as $oneMapDetail) {
                                    if($oneMapDetail->areaID == $oneObject->startAreaID) {
                                        echo $oneMapDetail->areaName;
                                    }
                                }
                        ?></td>
                        <td><?php 
                                foreach($data['map_details'] as $oneMapDetail) {
                                    if($oneMapDetail->areaID == $oneObject->endAreaID) {
                                        echo $oneMapDetail->areaName;
                                    }
                                }
                        ?></td>
                        <!-- <td><?php echo $oneObject->payMethod ?></td> -->
                        <td><?php echo $oneObject->currentLat  . " " . $oneObject->currentLong ?></td>
                    </tr>
                <?php endforeach; ?>
    </section>



</body>
</html>