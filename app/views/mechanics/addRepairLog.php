<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/addLog.css">
    <title>New Log</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require 'sidebar-mechanic.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

         <!-- dashboard section -->
        <?php require 'header.php'; ?>
        <form action="<?php echo URLROOT;?>/mechanics/addLog" method="POST" id="create_form">

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="data__area--top">
            <div class="data__area__top--title">New Log</div>
            <div class="data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/mechanics/repairLogsControl'">
                </div>
                <div class="delete_user_button">
                    <input type="submit" class="btn btn_delete" value="Submit">
                </div>
            </div>

        </div>

        <div class="data__area--detail">
            <div class="data__area__detail--top">
                <div class ="info" id="info_reportID">
                    <div class="main_text">Report ID</div>
                    <input type="text" name="reportID" class="sub_text2" placeholder="Report ID" value="<?php echo $data['reportID'];?>">
                    <span class="error_text"><?php echo $data['reportID_err'];?></span>
                </div>

                <div class ="info" id="info_bicycleID">
                    <div class="main_text">Bicycle ID</div>
                    <input type="text" name="bicycleID" class="sub_text2" placeholder="Bicycle ID" value="<?php echo $data['bicycleID'];?>">
                    <span class="error_text"><?php echo $data['bicycleID_err'];?></span>
                </div>

                <div class="info" id="info_mechanicID">
                    <div class="main_text">Mechanic ID</div>
                    <input type="text" name="mechanicID" class="sub_text2" placeholder="Mechanic ID" value="<?php echo $data['mechanicID'];?>">
                    <span class="error_text"><?php echo $data['mechanicID_err'];?></span>
                </div>
            </div>

            <div class="info" id="info_problemTitle">
                <div class="main_text">Problem Title</div>
                <input type="text" name="problemTitle" class="sub_text" placeholder="Problem Title" value="<?php echo $data['problemTitle'];?>">
                <span class="error_text"><?php echo $data['problemTitle_err'];?></span>
            </div>

            <div class="data__area__detail--month">
            <div class="data__area__div data--dateIn">
                <div class="date_time" id="info_dateTime">
                <div class="info">
                    <div class="main_text">Date In</div>
                        <input type="date" name="dateIn" id="date" class="sub_text1" value="<?php 
                            if(!$data['dateIn']):
                                    $month = date('m');
                                    $day = date('d');
                                    $year = date('Y');
                                    $today = $year . '-' . $month . '-' . $day;
                                    echo $today;
                            else: echo $data['dateIn'];
                            endif?>">
                        <span class="error_text"><?php echo $data['dateIn_err'];?></span>
                        </div>
                    </div>
            </div>
                    
            <div class="data__area__div data--dateOut">
                <div class="main_text">Date Out</div>
                        <input type="date" name="dateOut" id="date" class="sub_text1" value="<?php 
                            if(!$data['dateOut']):
                                    $month = date('m');
                                    $day = date('d');
                                    $year = date('Y');
                                    $today = $year . '-' . $month . '-' . $day;
                                    echo $today;
                            else: echo $data['dateIn'];
                            endif?>">
                        <span class="error_text"><?php echo $data['dateOut_err'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="data__area__detail--bottom">
                <div class="data__area__detail--cost">
                    <div class="info" id="info_estCost">
                        <div class="main_text">Estimated Cost</div>
                        <input type="text" name="estCost" class="sub_text3" placeholder="Estimated Cost" value="<?php echo $data['estCost'];?>">
                        <span class="error_text"><?php echo $data['estCost_err'];?></span>
                    </div>

                    <div class="info" id="info_finalCost">
                        <div class="main_text">Final Cost</div>
                        <input type="text" name="finalCost" class="sub_text3" placeholder="Final Cost" value="<?php echo $data['finalCost'];?>">
                        <span class="error_text"><?php echo $data['finalCost_err'];?></span>
                    </div>
                </div>

                <div class="info" id="info_repairNotes">
                            <div class="main_text">Repair Notes</div>
                            <textarea name="repairNotes" id="repairNotes" cols="30" rows="10" class="para_text" placeholder="Type here"><?php echo $data['repairNotes'];?></textarea>
                            <span class="error_text"><?php echo $data['repairNotes_err'];?></span>
                </div>
            </div>
        </div>
        </form>
    </section>
</body>
</html>