<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/viewBicycle.css">
    <title>Bicycle Details</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require 'sidebar-mechanic.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require 'header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/mechanics/editBicycleDetails" method="POST" id="userInterface">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">Edit Bicycle Details</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/mechanics/bicycleControl'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Update" >
                    </div>
                </div>

            </div>

            <div class="data__area--detail">

                <div class="data__area__detail--role">
                    <div class="data--name--lebal">Bicycle ID: <?php echo $data['bicycleDetailObject']->bicycleID;?></div>
                    <input type="hidden" name="bicycleID" value="<?php echo $data['bicycleDetailObject']->bicycleID;?>" id="bicycleID">
                </div>

                <div class="data__area__detail--name">

                    <div class="data__area__div data--bikeOwnerID">
                        <div class="data--name--lebal">Bicycle Owner ID</div>
                        <input type="number" class="detailbox" name="bikeOwnerID" value="<?php echo $data['bicycleDetailObject']->bikeOwnerID;?>" id="bikeOwnerID">
                        <br><span class="error_text"><?php echo $data['bikeOwnerID_err'];?></span>
                    </div>

                    <div class="data__area__div data--frameSize">
                        <div class="data--name--lebal">Frame Size</div>
                        <input type="number" class="detailbox" name="frameSize" value="<?php echo $data['bicycleDetailObject']->frameSize;?>" id="frameSize">
                        <br><span class="error_text"><?php echo $data['frameSize_err'];?></span>
                    </div>

                </div>

                <div class="data__area__detail--status">
                    <div class="data--name--lebal">Status</div>
                    <div class="data__status">
                        <div class="data__status--active">
                            <input type="radio" id="active" name="status" value="0" <?php if($data['bicycleDetailObject']->status == 0){echo 'checked';}?>>
                            <label for="active">Active</label>
                        </div>
                        <div class="data__status--inactive">
                            <input type="radio" id="inactive" name="status" value="1" <?php if($data['bicycleDetailObject']->status == 1){echo 'checked';}?>>
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                </div>

                <div class="data__area__detail--number">
                    <div class="data__area__detail--dateAcquired">
                        <div class="data--name--lebal">Date Acquired</div>
                        <input type="date" class="detailbox" name="dateAcquired" value="<?php echo $data['bicycleDetailObject']->dateAcquired;?>" id="dateAcquired">
                        <br><span class="error_text"><?php echo $data['dateAcquired_err'];?></span>
                    </div>
                    <div class="data__area__detail--datePutInUse">
                        <div class="data--name--lebal">Date Put Into Use</div>
                        <input type="date" class="detailbox" name="datePutInUse" value="<?php echo $data['bicycleDetailObject']->datePutInUse;?>" id="datePutInUse">
                        <br><span class="error_text"><?php echo $data['datePutInUse_err'];?></span>
                    </div>
                </div>

                <div class="data__area__detail--role">
                    <div class="data--name--lebal">Current Docking Area</div>
                    <input type="number" class="detailbox_userrole detailbox" name="currentDA" value="<?php echo $data['bicycleDetailObject']->currentDA;?>" id="currentDA">
                    <br><span class="error_text"><?php echo $data['currentDA_err'];?></span>
                </div>

            </div>
        </form>        
    </section>



</body>
</html>