<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/viewReports.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Reports</title>
</head>
<body>
<?php require APPROOT . '/views/inc/header-mechanic.php'; ?>

    <div id="container">

        <div id="upper_section">
            <div class="title" id="title">Reports</div>
            <div class="add_btn" id="add_btn">
                <a href="<?php echo URLROOT;?>/mechanics/createReport"><img src="<?php echo URLROOT;?>/public/images/general/add.png" alt="add"></a>
            </div>
        </div> 

        <div class="middle_section">
            <?php foreach($data['reportsDetailObject'] as $oneObject) : ?>
                <div class="reportRecord">
                    <div class="report">
                        <!-- div for status icon -->
                        <div class="status">
                            <?php if($oneObject->status == 0) : ?>
                                <img src="<?php echo URLROOT; ?>/public/images/general/active.png" alt="active" class="status_icon">
                            <?php elseif($oneObject->status == 1) : ?>
                                <img src="<?php echo URLROOT; ?>/public/images/general/resolved.png" alt="resolved" class="status_icon">
                            <?php endif; ?>
                        </div>

                        <div class="reportDetails">
                            <div class="sub_text">Report ID: <?php echo $oneObject->reportID; ?></div>
                            <div class="attribute_text">   
                                <!-- if the title is over 20 characters, stop and put ... -->
                                <?php if(strlen($oneObject->problemTitle) > 25) : 
                                    echo substr($oneObject->problemTitle, 0, 25);
                                    echo "...";
                                    else :
                                    echo $oneObject->problemTitle;
                                endif; ?>
                                <!-- <?php echo $oneObject->problemTitle; ?> -->
                            </div>
                        </div>
                    </div>
                    <div class="edit_btn">
                        <a href="<?php echo URLROOT;?>/mechanics/editReport?reportID=<?php echo $oneObject->reportID;?>"><img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit"></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</body>
</html>