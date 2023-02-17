<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/repairLog.css">
    <title>Repair Log</title>
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
            <div class="admin__data__area__top--title">Repair Log</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Report" onclick="location.href='<?php echo URLROOT;?>/admins/addAdministrator'">
                </div> -->
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/admins/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 3%;"></th>
                    <th style="width: 5%;">Log ID</th>
                    <th style="width: 6%;">Mechanic ID</th>
                    <th style="width: 5%;">Bicycle ID</th>
                    <th style="width: 10%;">Problem Title</th>
                    <th style="width: 15%;">Problem Description</th>
                    <!-- <th style="width: 8%;">Estimated Cost</th> -->
                    <th style="width: 5%;">Final Cost</th>
                    <th style="width: 7%;">Date In</th>
                    <th style="width: 7%;">Date Out</th>
                    <th style="width: 20%;">Repair Notes</th>
                    <th style="width: 7%;">Report ID</th>
                    <th style="width: 5%;"></th>

                    <?php foreach($data['repairLog_details'] as $oneObject) : ?>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td><?php echo $oneObject->logID ?></td>
                        <td><?php echo $oneObject->mechanicID ?></td>
                        <td><?php echo $oneObject->bicycleID ?></td>
                        <td><?php echo $oneObject->problemTitle ?></td>
                        <td><?php 
                                if(!$oneObject->problemDescription){
                                    echo "-";
                                }else{
                                    echo $oneObject->problemDescription;
                                }
                            ?>
                        </td>
                        <!-- <td><?php echo $oneObject->	estCost ?></td> -->
                        <td><?php 
                                if(!$oneObject->finalCost){
                                    echo "-";
                                }else{
                                    echo $oneObject->finalCost;
                                }
                            ?>
                        </td>
                        <td><?php echo $oneObject->	dateIn ?></td>
                        <td><?php 
                                if(!$oneObject->dateOut){
                                    echo "-";
                                }else{
                                    echo $oneObject->dateOut;
                                }
                            ?>
                        </td>
                        <td><?php 
                                if(!$oneObject->repairNotes){
                                    echo "-";
                                }else if(strlen($oneObject->repairNotes) > 50){
                                    echo substr($oneObject->repairNotes, 0, 50) . "...";
                                }else{
                                    echo $oneObject->repairNotes;
                                }
                                // echo $oneObject->	repairNotes ?></td>
                        <td><?php 
                                if(!$oneObject->reportID){
                                    echo "-";
                                }else{
                                    echo $oneObject->reportID;
                                }
                            ?>
                        </td>
                        <td>
                        <!-- update icon svg format -->
                        <form action="<?php echo URLROOT;?>/admins/viewRepairLog" method="get">
                                <input type="hidden" name="logID" value="<?php echo $oneObject->logID;?>">
                                <input type="image" src="<?php echo URLROOT;?>/public/images/admins/viewIcon1.png">
                        </form>

                    </tr>
                <?php endforeach; ?>


            </table>
        </div>
    </section>



</body>
</html>