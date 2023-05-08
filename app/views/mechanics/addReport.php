<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/addReport.css">
    <title>New Report</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require 'sidebar-mechanic.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require 'header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="data__area--top">
            <div class="data__area__top--title">New Report</div>
            <div class="data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/mechanics/reportsControl'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Submit" onclick="location.href='<?php echo URLROOT;?>/mechanics/reportsControl'">
                </div>
            </div>
        </div>

        <div class="data__area--detail">

            

            <div class="data__area__div data--report">
                    <div class="data--name--lebal">Status</div>
                    <div class="data__area__div data--reporterID">
                        <div class="data--name--lebal">Reporter ID</div>
                        <input type="text" class="detailbox"  placeholder="Reporter ID" id="fName">
                    </div>
                    <div class="data__status">
                        <div class="data__status--active">
                            <input type="radio" id="active" name="status" value="1" checked>
                            <label for="active">Active</label>
                        </div>
                        <div class="data__status--inactive">
                            <input type="radio" id="inactive" name="status" value="0" >
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
                    <div class="data__area__div data--mechanicID">
                        <div class="data--name--lebal">Mechanic ID</div>
                        <input type="text" class="detailbox" placeholder="Mechanic ID" id="fName">
                    </div>
                </div>

            <div class="data__area__div data--problemTitle">
                <div class="data--name--lebal">Problem Title</div>
                <input type="text" class="detailbox__problemtitle detailbox" placeholder="Problem ID" id="fName">
                <!-- <textarea name="" id="fName" class="detailbox" cols="30" rows="5" placeholder="Problem Title"></textarea> -->
            </div>

            <div class="data__area__detail--number">
                    <div class="data__area__detail--dateAcquired">
                        <div class="data--name--lebal">Date Acquired</div>
                        <input type="date" class="detailbox" name="dateAcquired" placeholder="Date Acquired" id="dateAcquired">
                        <br><span class="error_text"><?php echo $data['dateAcquired_err'];?></span>
                    </div>
                    <div class="data__area__detail--datePutInUse">
                        <div class="data--name--lebal">Date Put Into Use</div>
                        <input type="date" class="detailbox" name="datePutInUse" placeholder="Date Put Into Use" id="datePutInUse">
                        <br><span class="error_text"><?php echo $data['datePutInUse_err'];?></span>
                    </div>
            </div>

            <div class="data__area__div data--repairDescription">
                <div class="data--name--lebal">Repair Description</div>
                <!-- <input type="text" class="detailbox" placeholder="Repair Description" id="fName"> -->
                <textarea name="" id="fName" class="detailbox" cols="30" rows="7" placeholder="Repair Description"></textarea>
            </div>

            <div class="data__area__div data--estimatedCost">
                <div class="data--name--lebal">Estimated Cost</div>
                <input type="text" class="detailbox" placeholder="Estimated Cost" id="fName">
            </div>

            <div class="data__area__div data--finalCost">
                <div class="data--name--lebal">Final Cost</div>
                <input type="text" class="detailbox" placeholder="Final Cost" id="fName">
            </div>
        </div>
    </section>
</body>
</html>