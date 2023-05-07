<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/addUser.css">
    <title>Docking Area Details</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/owners/editDADetails" method="POST" id="userInterface">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">Edit Docking Area</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/owners/dockingareas'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Update" >
                    </div>
                </div>

            </div>

            <div class="data__area--detail">
                <div class="data__area__detail--role">
                    <div class="data--name--lebal">Area ID: <?php echo $data['areaDetailObject']->areaID;?></div>
                    <input type="hidden" name="areaID" value="<?php echo $data['areaDetailObject']->areaID;?>" id="areaID">
                </div>

                <div class="data__area__detail--name"> 

                    <div class="data__area__div data--areaname">
                        <div class="data--name--lebal">Area Name</div>
                        <input type="text" class="detailbox" name="areaName" value="<?php echo $data['areaDetailObject']->areaName;?>" id="areaName">
                        <br><span class="error_text"><?php echo $data['areaName_err'];?></span>
                    </div>

                    <div class="data__area__div data--locationradius">
                        <div class="data--name--lebal">Location Radius</div>
                        <input type="text" class="detailbox" name="locationRadius" value="<?php echo $data['areaDetailObject']->locationRadius;?>" id="locationRadius">
                        <br><span class="error_text"><?php echo $data['locationRadius_err'];?></span>
                    </div>

                </div>

                <div class="data__area__detail--email">
                    <div class="data--email--lebal">Traditional Address</div>
                    <input type="text" class="detailbox detailbox--email" name="traditionalAdd" value="<?php echo $data['areaDetailObject']->traditionalAdd;?>" id="traditionalAdd">
                    <br><span class="error_text"><?php echo $data['traditionalAdd_err'];?></span>
                </div>

                <div class="data__area__detail--status">
                    <div class="data--name--lebal">Status</div>
                    <div class="data__status">
                        <div class="data__status--active">
                            <input type="radio" id="active" name="status" value="0" <?php if($data['areaDetailObject']->status == 0){echo 'checked';}?>>
                            <label for="active">Active</label>
                        </div>
                        <div class="data__status--inactive">
                            <input type="radio" id="inactive" name="status" value="1" <?php if($data['areaDetailObject']->status == 1){echo 'checked';}?>>
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="data__area__detail--number">
                    <div class="data__area__detail--latitude">
                        <div class="data--name--lebal">Latitude</div>
                        <input type="text" class="detailbox" name="locationLat" value="<?php echo $data['areaDetailObject']->locationLat;?>" id="locationLat">
                        <br><span class="error_text"><?php echo $data['locationLat_err'];?></span>
                    </div>
                    <div class="data__area__detai--longitude">
                        <div class="data--name--lebal">Longitude</div>
                        <input type="text" class="detailbox" name="locationLong" value="<?php echo $data['areaDetailObject']->locationLong;?>" id="locationLong">
                        <br><span class="error_text"><?php echo $data['locationLong_err'];?></span>
                    </div>
                </div>

                <div class="data__area__detail--role">
                    <div class="data--name--lebal">Current Number Of Bikes</div>
                    <input type="text" class="detailbox_userrole detailbox" name="currentNoOfBikes" value="<?php echo $data['areaDetailObject']->currentNoOfBikes;?>" id="currentNoOfBikes">
                    <br><span class="error_text"><?php echo $data['currentNoOfBikes_err'];?></span>
                </div>

            </div>
        </form>       
    </section>
</body>
</html>