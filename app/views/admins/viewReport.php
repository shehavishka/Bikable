<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/viewReport.css">
    <title>Report</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/admins/editReportDetails" method="POST" id="userInterface">
            <input type="hidden" name="reportID" value="<?php echo $data['reportDetailObject']->reportID;?>" id="reportID">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">View Report</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/admins/reportsControl'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Update">
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

                <div class="data__area__detail--status">
                        <div class="data--name--label">Status: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->status){echo $data['reportDetailObject']->problemDescription;}else{echo "-";}?></div>
                </div>
                
                <div class="data__area__detail--problemTitle">
                        <div class="data--name--label">Problem Title: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->problemTitle;?></div>
                </div>

                <div class="data__area__detail--problemDescription">
                        <div class="data--name--label">Problem Description: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->problemDescription){echo $data['reportDetailObject']->problemDescription;}else{echo "-";}?></div>
                </div>

                <div class="data__area__detail--loggedTimestamp">
                        <div class="data--name--label">Logged Time: </div>
                        <div class="data--name--content"><?php echo $data['reportDetailObject']->loggedTimestamp;?></div>
                </div>
                
                <div class="data__area__detail--mechanicID">
                        <div class="data--name--label">Assigned Mechanic ID: </div>
                        <!-- <div class="data--name--content"><?php if($data['reportDetailObject']->assignedMechanic){echo $data['reportDetailObject']->assignedMechanic;}else{echo "-";}?></div> -->
                        <input type="number" class="detailbox" name="mechanicID" value="<?php echo $data['reportDetailObject']->assignedMechanic;?>" placeholder="-" id="assignedMechanic">
                        <br><span class="error_text"><?php echo $data['mechanicID_err'];?></span>
                </div>

                <div class="data__area__detail--reportType">
                        <div class="data--name--label">Report Type: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->reportType){echo $data['reportDetailObject']->reportType;}else{echo "-";}?></div>
                </div>

                <?php if($data['reportDetailObject']->reportType == "Accident"){ ?>
                <div class="data__area__detail--accidentLocation">
                        <div class="data--name--label">Accident Location: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->accidentLat){echo $data['reportDetailObject']->accidentLat." ".$data['reportDetailObject']->accidentLong;}else{echo "-";}?></div>
                </div>

                <!-- <div class="data__area__detail--repairNotes">
                        <div class="data--name--label">Repair Notes: </div>
                        <div class="data--name--content"> <?php if($data['reportDetailObject']->repairNotes){echo $data['reportDetailObject']->repairNotes;}else{echo "-";}?></div>
                </div> -->
                
                <div class="data__area__detail--accidentTimeApprox">
                        <div class="data--name--label">Approximate Time of Occurrence: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->accidentTimeApprox){echo $data['reportDetailObject']->accidentTimeApprox;}else{echo "-";}?></div>
                </div>
                <?php }?>

                <?php if($data['reportDetailObject']->reportType == "Accident" || $data['reportDetailObject']->reportType == "Bicycle"){ ?>
                <div class="data__area__detail--bicycleID">
                        <div class="data--name--label">Bicycle ID: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->bicycleID){echo $data['reportDetailObject']->bicycleID;}else{echo "-";}?></div>
                </div>
                <?php }?>

                <?php if($data['reportDetailObject']->reportType == "Area"){ ?>
                <div class="data__area__detail--areaID">
                        <div class="data--name--label">Area ID: </div>
                        <div class="data--name--content"><?php if($data['reportDetailObject']->areaID){echo $data['reportDetailObject']->areaID;}else{echo "-";}?></div>
                </div>
                <?php }?>
                
            </div>

        </form>