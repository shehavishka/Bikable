<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/viewProfile.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Profile Page</title>
    <!-- <script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script> -->
</head>
<body>
<?php require APPROOT . '/views/inc/header-rider.php'; ?>

    <div id="container">
        <div id="upper_section">
            <div class="title" id="title">Edit Profile</div>
        </div>         
        
        <form action="<?php echo URLROOT;?>/riders/profileEdit" method="POST" id="edit_form">
            <div class="middle_section2">
                
                    <div class="info">
                        <div class="main_text1">Name</div>
                        <input type="text" name="name" id="name" class="sub_text1" value="<?php echo($data['userDetailObject']->firstName . " " . $data['userDetailObject']->lastName); ?>">
                        <span class="error_text"><?php echo $data['name_Err'];?></span>
                    </div>
                    <div class="info">
                        <div class="main_text1">Email</div>
                        <input type="text" name="email" id="email" class="sub_text1" value="<?php echo $data['userDetailObject']->emailAdd; ?>">
                        <span class="error_text"><?php echo $data['email_Err'];?></span>

                    </div>
                    <div class="info">
                        <div class="main_text1">Phone Number</div>
                        <input type="text" name="phone" id="phone" class="sub_text1" value="<?php echo $data['userDetailObject']->phoneNumber; ?>">
                        <span class="error_text"><?php echo $data['phone_Err'];?></span>
                    </div>
                    <div class="info">
                        <div class="main_text1">NIC</div>
                        <input type="text" name="NIC" id="NIC" class="sub_text1" value="<?php echo $data['userDetailObject']->NIC; ?>">
                        <span class="error_text"><?php echo $data['NIC_Err'];?></span>
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