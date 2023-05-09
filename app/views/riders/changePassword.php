<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/viewProfile.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Change Password</title>
    <!-- <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script> -->
</head>
<body>
<?php require APPROOT . '/views/inc/header-rider.php'; ?>

    <div id="container">
        <div id="upper_section">
            <div class="title" id="title">Change Password</div>
        </div>         
        
        <form action="<?php echo URLROOT;?>/riders/changePassword" method="POST" id="change_form">
            <div class="middle_section2">
                <div class="info">
                    <div class="main_text1">Current Password</div>
                    <input type="text" name="oldPassword" id="oldPassword" class="sub_text1" placeholder="Type here">
                    <span class="error_text"><?php echo $data['oldPassword_Err'];?></span>
                </div>
                <div class="info">
                    <div class="main_text1">New Password</div>
                    <input type="password" name="newPassword" id="newPassword" class="sub_text1" placeholder="Minimum 8 characters">
                    <span class="error_text"><?php echo $data['newPassword_Err'];?></span>

                </div>
                <div class="info">
                    <div class="main_text1">Confirm New Password</div>
                    <input type="password" name="confirmPassword" id="confirmPassword" class="sub_text1" >
                    <span class="error_text"><?php echo $data['confirmPassword_Err'];?></span>
                </div>
            </div>
        

        <div id="lower_section2">
            <!-- <div class="done_btn"><input type="submit" class="done_btn" value="Done" ></div> -->
            <input type="submit" class="done_btn" value="Done" >
            
            </form>
            <a href="<?php echo URLROOT;?>/riders/profilePage"><div class="cancel_btn">Cancel</div></a>
        </div> 

    </div>
</body>
</html>