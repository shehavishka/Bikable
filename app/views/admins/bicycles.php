<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/bicycles.css">
    <title>Bicycles</title>
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
            <div class="admin__data__area__top--title">Bicycles</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Bicycle" onclick="location.href='<?php echo URLROOT;?>/admins/addBicycle'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/admins/addAdministrator'">
                </div>
            </div>

        </div>


        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 10%;">Bicycle ID</th>
                    <th style="width: 10%;">Bicycle Owner ID</th>
                    <th style="width: 10%;">Status</th>
                    <th style="width: 10%;">Frame Size</th>
                    <th style="width: 10%;">Date Acquired</th>
                    <th style="width: 10%;">Date put into use</th>
                    <th style="width: 10%;">Current Location</th>
                    <th style="width: 5%;"></th>

                <?php foreach($data['bike_details'] as $oneObject) : ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->bikeOwnerID ?></td>
                        <td>
                            <?php 
                                if($oneObject->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneObject->frameSize ?></td>
                        <td><?php echo $oneObject->dateAcquired ?></td>
                        <td><?php echo $oneObject->	datePutInUse ?></td>
                        <td><?php echo $oneObject->	currentDA ?></td>
                        <td>
                        <!-- update icon svg format -->
                        <form action="<?php echo URLROOT;?>/admins/editBicycleDetails" method="get">
                                <input type="hidden" name="bicycleID" value="<?php echo $oneObject->bicycleID;?>">
                                <input type="image" src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png">
                        </form>

                    </tr>
                <?php endforeach; ?>


            </table>
        </div>
    </section>



</body>
</html>