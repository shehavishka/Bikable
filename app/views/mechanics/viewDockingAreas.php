<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/viewDockingAreas.css">
    <title>View Docking Area</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require 'sidebar-mechanic.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require 'header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/mechanics/deleteRepairLog" method="POST" id="userInterface">
            <input type="hidden" name="areaID" value="<?php echo $data['areaObject']->areaID;?>" id="areaID">
            <!-- mechanic real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">View Docking Area</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/mechanics/dockingAreas'">
                    </div>
                    <!-- <div class="delete_user_button">
                        <input type="submit" class="
                        btn btn_delete" value="Delete">
                    </div> -->
                </div>

            </div>

            <div class="data__area--detail">

                <div class="data__area__detail--areaID">
                        <div class="data--name--label">Area ID: </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->areaID;?></div>
                </div>

                <div class="data__area__detail--areaName">
                        <div class="data--name--label">Area Name: </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->areaName;?></div>
                </div>

                <div class="data__area__detail--locationLat">
                        <div class="data--name--label">Latitude: </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->locationLat;?></div>
                </div>

                <div class="data__area__detail--locationLong">
                        <div class="data--name--label">Longitude: </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->locationLong;?></div>
                </div>

                <div class="data__area__detail--status">
                    <div class="data--name--lebal">Status</div>
                    <div class="data__status">
                        <div class="data__status--active">
                            <input type="radio" id="active" name="status" value="0" <?php if($data['areaObject']->status == 0){echo 'checked';}?>>
                            <label for="active">Active</label>
                        </div>
                        <div class="data__status--inactive">
                            <input type="radio" id="inactive" name="status" value="1" <?php if($data['areaObject']->status == 1){echo 'checked';}?>>
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="data__area__detail--traditionalAdd">
                        <div class="data--name--label">Address </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->traditionalAdd;?></div>
                </div>

                <div class="data__area__detail--currentNoOfBikes">
                        <div class="data--name--label">Current Bikes </div>
                        <div class="data--name--content"><?php echo $data['areaObject']->currentNoOfBikes;?></div>
                </div>

            </div>

        </form>