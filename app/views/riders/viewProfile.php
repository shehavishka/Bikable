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
            <div class="title" id="title">Profile Page</div>
            <div class="edit_btn" id="edit_btn">
                <!-- on click of edit icon calls showEdit() function -->                
                <!-- <img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit" onclick="showEdit()"> -->
                <a href="<?php echo URLROOT;?>/riders/profileEdit"><img src="<?php echo URLROOT;?>/public/images/admins/editIcon1.png" alt="edit" onclick="showEdit()"></a>
            </div>
        </div> 
        <div class="middle_section1">
            <div class="info">
                <div class="main_text">Name</div>
                <div class="sub_text"><?php echo($data['userDetailObject']->firstName . " " . $data['userDetailObject']->lastName); ?></div>
            </div>
            <div class="info">
                <div class="main_text">Email</div>
                <div class="sub_text"><?php echo $data['userDetailObject']->emailAdd; ?></div>
            </div>
            <div class="info">
                <div class="main_text">Phone Number</div>
                <div class="sub_text"><?php echo $data['userDetailObject']->phoneNumber; ?></div>
            </div>
            <div class="info">
                <div class="main_text">NIC</div>
                <div class="sub_text"><?php echo $data['userDetailObject']->NIC; ?></div>
            </div>
        </div>
        
        <hr class="hr1">

        <div id="lower_section1">
            <a href="<?php echo URLROOT;?>/riders/changePassword"><div class="change_btn">Change Password</div>
            <a href="<?php echo URLROOT;?>/riders/riderLandPage"><div class="delete_btn">Delete Account</div>
        </div> 

    </div>

    <!-- <script>
        function showEdit(){
            // hide edit button, middle section1 and lower section1 and hr
            document.getElementById("edit_btn").style.display = "none";
            document.getElementsByClassName("middle_section1")[0].style.display = "none";
            document.getElementById("lower_section1").style.display = "none";
            document.getElementsByClassName("hr1")[0].style.display = "none";

            //show middle section2 and lower section2
            document.getElementsByClassName("middle_section2")[0].style.display = "flex";
            document.getElementById("lower_section2").style.display = "flex";

            // change title to Edit Profile
            document.getElementById("title").innerHTML = "Edit Profile";
        }

        function hideEdit(){
            // do the opposite of showEdit
            document.getElementById("edit_btn").style.display = "flex";
            document.getElementsByClassName("middle_section1")[0].style.display = "flex";
            document.getElementById("lower_section1").style.display = "flex";
            document.getElementsByClassName("hr1")[0].style.display = "block";

            document.getElementsByClassName("middle_section2")[0].style.display = "none";
            document.getElementById("lower_section2").style.display = "none";

            document.getElementById("title").innerHTML = "Profile Page";
        }
    </script> -->
</body>
</html>