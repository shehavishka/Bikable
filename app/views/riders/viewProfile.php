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
            <a href="<?php echo URLROOT;?>/riders/changePassword"><div class="change_btn">Change Password</div></a>
            
            <div class="delete_btn" id="delete_btn">Delete Account</div>
        </div> 

    </div>

    <script>
        const delete_btn = document.getElementById("delete_btn");
        delete_btn.addEventListener("click", function() {deleteForm();});

        function deleteForm(){
            if(window.confirm("Are you sure you want to delete your account?")){
                //creates a form element with userID as a field and submits it
                var form = document.createElement("form");
                form.setAttribute("method", "post");
                form.setAttribute("action", "<?php echo URLROOT;?>/riders/deleteAccount");

                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", "userID");
                hiddenField.setAttribute("value", "<?php echo $_SESSION['user_ID']; ?>");

                form.appendChild(hiddenField);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>