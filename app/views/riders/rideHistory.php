<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/rideHistory.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Profile Page</title>
</head>
<body>
<?php require APPROOT . '/views/inc/header-rider.php'; ?>

    <div id="container">

        <div id="upper_section">
            <div class="title" id="title">Ride History</div>
        </div> 

        <div class="middle_section">
            <!-- foreach record in the rideHistoryDetailObject, show rideID and then a table, where one coloumn is From:, To:, Start time:, Duration:, Fare:, Payment: and the second column are the values-->
            <?php foreach($data['rideHistoryDetailObject'] as $oneObject) : ?>
                <div class="rideRecord">
                    <div class="rideID">
                    <div class="attribute_text">Ride ID: </div>
                        <div class="sub_text"><?php echo $oneObject->rideLogID; ?></div>
                    </div>
                    <div class="rideDetails">
                        <table>
                            <tr>
                                <td><div class="attribute_text">From:</div></td>
                                <td><div class="sub_text"><?php 
                                    foreach($data['mapDetails'] as $oneMapDetail) {
                                        if($oneMapDetail->areaID == $oneObject->startAreaID) {
                                            echo $oneMapDetail->areaName;
                                        }
                                    }
                                ?></div></td>
                            </tr>
                            <tr>
                                <td><div class="attribute_text">To:</div></td>
                                <td><div class="sub_text"><?php 
                                    foreach($data['mapDetails'] as $oneMapDetail) {
                                        if($oneMapDetail->areaID == $oneObject->endAreaID) {
                                            echo $oneMapDetail->areaName;
                                        }
                                    }
                                ?></div></td>
                            </tr>
                            <tr>
                                <td><div class="attribute_text">Start time:</div></td>
                                <td><div class="sub_text"><?php echo $oneObject->rideStartTimeStamp; ?></div></td>
                            </tr>
                            <tr>
                                <td><div class="attribute_text">Duration:</div></td>
                                <td><div class="sub_text"><?php 
                                    $hours = floor($oneObject->timeTravelled / 3600);
                                    $minutes = floor(($oneObject->timeTravelled / 60) % 60);
                                    $seconds = $oneObject->timeTravelled % 60;

                                    echo $hours . 'h' . $minutes . 'm' . $seconds . 's'; 
                                ?></div></td>
                            </tr>
                            <tr>
                                <td><div class="attribute_text">Fare:</div></td>
                                <td><div class="sub_text"><?php echo $oneObject->fare; ?> LKR</div></td>
                            </tr>
                            <tr>
                                <td><div class="attribute_text">Payment:</div></td>
                                <td><div class="sub_text"><?php echo $oneObject->payMethod; ?></div></td>
                            </tr>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
    </div>
</body>
</html>