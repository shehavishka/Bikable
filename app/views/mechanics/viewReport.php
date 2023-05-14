<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/viewRepairLog.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/mechanics/favicon.png">
    <title>Edit Report</title>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
</head>
<body>
<?php require 'sidebar-mechanic.php'; ?>

<section class="data_area">
    <?php require 'header.php'; ?>

            <div id="upper_section">
            </div>         
            

            <form action="<?php echo URLROOT;?>/mechanics/viewReport" method="POST" id="userInterface">
            <!-- <input type="hidden" name="reportID" value="<?php echo $data['reportDetailObject']->reportID;?>" id="reportID"> -->
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">View Report</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/mechanics/reportsControl'">
                    </div>
                    <!-- <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Update">
                    </div> -->
                </div>

            </div> 

            <div class="data__area--detail">
                <div class="data__area__detail--reportID">
                    <div class="data--name--label">Report ID: </div>
                    <div class="data--name--content"><?php echo $data['reportID'];?></div>
                </div>

                <div class="data__area__detail--type">
                    <div class="data--name--label">Type: </div>
                    <div class="data--name--content"><?php echo $data['type'];?></div>
                </div>

                <div class="data__area__detail--reporterID">
                    <div class="data--name--label">Reporter ID: </div>
                    <div class="data--name--content"><?php echo $data['reporterID'];?></div>
                </div>

                <div class="data__area__detail--problemTitle">
                    <div class="data--name--label">Problem Title: </div>
                    <div class="data--name--content"><?php echo $data['problemTitle'];?></div>
                </div>

                <div class="data__area__detail--problemDescription">
                    <div class="data--name--label">Problem Description: </div>
                    <div class="data--name--content"><?php echo $data['problemDescription'];?></div>
                </div>

                <div class="data__area__detail--assignedMechanic">
                    <div class="data--name--label">Assigned Mechanic: </div>
                    <div class="data--name--content"><?php echo $data['assignedMechanic'];?></div>
                </div>

                <div class="data__area__detail--loggedTimestamp">
                    <div class="data--name--label">Logged Timestamp: </div>
                    <div class="data--name--content"><?php echo $data['accidentTimeStamp'];?></div>   
                </div>

                <div class="data__area__detail--accidentLocation">
                    <div class="data--name--label">Accident Location: </div>
                    <div class="data--name--content"><?php echo $data['accidentLocation'];?></div> 
                </div>

                <div class="data__area__detail--bicycleID">
                    <div class="data--name--label">Bicycle ID: </div>
                    <div class="data--name--content"><?php echo $data['bicycleID'];?></div>
                </div>
                
                <div class="data__area__detail--areaID">
                    <div class="data--name--label">Area ID: </div>
                    <div class="data--name--content"><?php echo $data['areaID'];?></div>
                </div>

        </form>
    </section>     
</body>
</html>