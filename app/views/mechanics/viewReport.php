<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/viewRepairLog.css">
    <title>Repair Log</title>
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
            <input type="hidden" name="logID" value="<?php echo $data['reportDetailObject']->reportID;?>" id="reportID">
            <!-- mechanic real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">View Repair report</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/mechanics/repairreportsControl'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="
                        btn btn_delete" value="Delete">
                    </div>
                </div>

            </div>

            <div class="data__area--detail">

                <div class="data__area__detail--reportID">
                        <div class="data--name--label">Report ID: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->reportID;?></div>
                </div>

                <div class="data__area__detail--reporterID">
                        <div class="data--name--label">Reporter ID: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->reporterID;?></div>
                </div>

                <div class="data__area__detail--problemTitle">
                        <div class="data--name--label">Problem Title: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->problemTitle;?></div>
                </div>

                <div class="data__area__detail--problemDescription">
                        <div class="data--name--label">Problem Description: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->problemDescription){echo $data['reportDetailObject']->problemDescription;}else{echo "-";}?></div>
                </div>

                <div class="data__area__detail--estCost">
                        <div class="data--name--label">Estimated Cost: </div>
                        <div class="data--name--content"><?php echo "LKR ".$data['reportDetailObject']->estCost;?></div>
                </div>

                <div class="data__area__detail--finalCost">
                        <div class="data--name--label">Final Cost: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->finalCost){echo "LKR ".$data['reportDetailObject']->finalCost;}else{echo "-";}?></div>
                </div>

                <div class="data__area__detail--dateIn">
                        <div class="data--name--label">Date In: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->dateIn;?></div>
                </div>

                <div class="data__area__detail--dateOut">
                        <div class="data--name--label">Date Out: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->dateOut){echo $data['reportDetailObject']->dateOut;}else{echo "-";}?></div>
                </div>

                <div class="data__area__detail--repairNotes">
                        <div class="data--name--label">Repair Notes: </div>
                        <div class="data--name--content"> <?php if($data['reportDetailObject']->repairNotes){echo $data['reportDetailObject']->repairNotes;}else{echo "-";}?></div>
                </div>

                <div class="data__area__detail--reportID">
                        <div class="data--name--label">Report ID: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->reportID){echo $data['reportDetailObject']->reportID;}else{echo "-";}?></div>
                </div>

            </div>

        </form>