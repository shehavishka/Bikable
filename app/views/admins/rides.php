<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/rides.css">
    <title>Rides</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

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
                    <th style="width: 2%;"></th>
                    <th style="width: 5%;">Rider ID</th>
                    <th style="width: 6%;">Bicycle ID</th>
                    <th style="width: 5%;">Status</th>
                    <th style="width: 5%;">Started At</th>
                    <th style="width: 8%;">Ended At</th>
                    <th style="width: 8%;">Fare</th>
                    <th style="width: 8%;">Travelled Time</th>
                    <th style="width: 5%;">Start Area</th>
                    <th style="width: 5%;">End Area</th>
                    <th style="width: 7%;">Payment Method</th>
                    <th style="width: 10%;">Current Location</th>

                    <?php foreach($data['ride_details'] as $oneObject) : ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo $oneObject->rideID ?></td>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 1){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject->startTime ?></td>
                        <td><?php echo $oneObject->endTime ?></td>
                        <td><?php echo $oneObject->fare ?></td>
                        <td><?php echo $oneObject->timeTravelled ?></td>
                        <td><?php echo $oneObject->startArea ?></td>
                        <td><?php echo $oneObject->endArea ?></td>
                        <td><?php echo $oneObject->payMethod ?></td>
                        <td><?php echo $oneObject->currentLat  . " " . $oneObject->currentLong ?></td>
                    </tr>
                <?php endforeach; ?>
    </section>



</body>
</html>