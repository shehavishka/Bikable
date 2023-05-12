<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/rideEnded.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Ride Ended</title>
    <!-- <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script> -->
</head>
<body>
    <div id="container">
        <div id="upper_section">
            <div class="main_text">Thank you for riding with us</div>
            <div class="sub_text">See you soon!</div>
        </div> 
        <hr>
        <div class="middle_section">
            <!-- php echo the values in data -->
            <div class="info">
                <div class="sub_text">Time Spent:</div>
                <div class="main_text"><?php 
                    $hours = floor($data['time_spent'] / 3600);
                    $minutes = floor(($data['time_spent'] / 60) % 60);
                    $seconds = $data['time_spent'] % 60;

                    echo $hours . 'h' . $minutes . 'm' . $seconds . 's'; 
                ?></div>
            </div>
            <div class="info">
                <div class="sub_text">Final Fare:</div>
                <div class="main_text"><?php echo $data['fare'] . " LKR"; ?></div>
            </div>
            <div class="info">
                <div class="sub_text">Payment Method:</div>
                <div class="main_text"><?php echo $data['payMethod']; ?></div>
            </div>
        </div>

        <div id="lower_section">
            <a href="<?php echo URLROOT;?>/riders/riderLandPage"><div class="back_btn">Back to Home</div></a>
        </div> 

    </div>
</body>
</html>