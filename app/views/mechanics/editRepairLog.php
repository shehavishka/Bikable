<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/mechanics/addReport.css">
    <link rel="icon" href="<?php echo URLROOT; ?>/public/images/mechanics/favicon.png">
    <title>Edit Report</title>
    <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
</head>

<body>
    <?php require 'sidebar-mechanic.php'; ?>

    <section class="data_area">
        <?php require 'header.php'; ?>


        <form action="<?php echo URLROOT; ?>/mechanics/addReport" method="POST" id="create_form">

            <div class="data__area--top">
                <div class="data__area__top--title">Add Report</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT; ?>/mechanics/reportsControl'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Submit" onclick="location.href='<?php echo URLROOT; ?>/mechanics/editReport'">
                        </div>
                    </div>

            </div> 

            <div class=" data__area--detail">
                        <div class="info" id="info_type">
                            <div class="data--name--label">Report ID: <?php echo $data['repairLogDetailObject']->reportID; ?></div>
                            <input type="hidden" name="reportID" value="<?php echo $data['repairLogDetailObject']->reportID; ?>" id="reportID">
                        </div>

                        <div class="info" id="info_type">
                            <div class="data--name--label">Repair Log ID: <?php echo $data['repairLogDetailObject']->repairLogID; ?></div>
                            <input type="hidden" name="repairLogID" value="<?php echo $data['repairLogDetailObject']->repairLogID; ?>" id="repairLogID">
                        </div>

                        <div class="info" id="info_title">
                            <div class="data--name--label">Mechanic ID: <?php echo $data['repairLogDetailObject']->mechanicID; ?></div>
                            <input type="hidden" name="mechanicID" value="<?php echo $data['repairLogDetailObject']->mechanicID; ?>" id="mechanicID">
                        </div>
                        <div class="info" id="info_title">
                            <div class="data--name--label">Problem Title: <?php echo $data['repairLogObject']->problemTitle; ?></div>
                            <input type="hidden" name="problemTitle" value="<?php echo $data['repairLogObject']->problemTitle; ?>" id="problemTitle">
                        </div>
                        <div class="info" id="info_description">
                            <div class="main_text">Description</div>
                            <textarea name="problemDescription" id="problemDescription" cols="30" rows="10" class="para_text" placeholder="Type here"><?php echo $data['problemDescription']; ?></textarea>
                            <span class="error_text"><?php echo $data['problemDescription_Err']; ?></span>
                        </div>
                        <div class="info" id="info_title">
                            <div class="data--name--label">Bicycle ID: <?php echo $data['repairLogObject']->bicycleID; ?></div>
                            <input type="hidden" name="bicycleID" value="<?php echo $data['repairLogObject']->bicycleID; ?>" id="bicycleID">
                        </div>


                        <div class="info" id="info_area">
                            <div class="main_text">Docking Area Name</div>
                            <!-- a drop down with selections being from the $data['mapDetails']->areaName value and value being the $data['mapDetails']->areaID -->
                            <select name="areaID" id="areaID" class="sub_text">
                                <option value="0" <?php if (empty($data['areaID'])) echo 'selected'; ?> hidden>Choose here</option>
                                <?php foreach ($data['mapDetails'] as $mapDetail) : ?>
                                    <option value="<?php echo $mapDetail->areaID; ?>" <?php if ($data['areaID'] == $mapDetail->areaID) echo 'selected'; ?>><?php echo $mapDetail->areaName; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="error_text"><?php echo $data['areaID_Err']; ?></span>
                        </div>
                        <div class="info" id="info_location">
                            <div class="data--name--label">Estimated Cost: <?php echo $data['repairLogObject']->estCost; ?></div>
                            <input type="hidden" name="estCost" value="<?php echo $data['repairLogObject']->estCost; ?>" id="estCost">
                        </div>
                    </div>
                    <div class="date_time" id="info_dateTime">
                        <div class="info">
                            <div class="main_text">Date In</div>
                            <input type="date" name="date" id="date" class="sub_text1" value="<?php
                                                                                                if (!$data['dateIn']) :
                                                                                                    $month = date('m');
                                                                                                    $day = date('d');
                                                                                                    $year = date('Y');
                                                                                                    $today = $year . '-' . $month . '-' . $day;
                                                                                                    echo $today;
                                                                                                else : echo $data['dateIn'];
                                                                                                endif ?>">
                            <span class="error_text"><?php echo $data['date_Err']; ?></span>
                        </div>

                        <div class="info">
                            <div class="main_text">Date Out</div>
                            <input type="date" name="date" id="date" class="sub_text1" value="<?php
                                                                                                if (!$data['dateOut']) :
                                                                                                    $month = date('m');
                                                                                                    $day = date('d');
                                                                                                    $year = date('Y');
                                                                                                    $today = $year . '-' . $month . '-' . $day;
                                                                                                    echo $today;
                                                                                                else : echo $data['dateOut'];
                                                                                                endif ?>">
                            <span class="error_text"><?php echo $data['date_Err']; ?></span>
                        </div>

                        <div class="info" id="info_location">
                            <div class="data--name--label">Final Cost: <?php echo $data['repairLogObject']->finalCost; ?></div>
                            <input type="hidden" name="finalCost" value="<?php echo $data['repairLogObject']->finalCost; ?>" id="finalCost">
                        </div>

                        <div class="info" id="info_description">
                            <div class="main_text">Repair Notes</div>
                            <textarea textarea name="problemDescription" id="problemDescription" cols="30" rows="10" class="para_text" placeholder="Type here"><?php echo $data['problemDescription']; ?></textarea>
                            <span class="error_text"><?php echo $data['problemDescription_Err']; ?></span>
                        </div>
                    </div>
                </form>
    </section>
</body>

</html>