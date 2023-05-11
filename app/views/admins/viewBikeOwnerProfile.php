<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/viewBikeOwner.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Bicycle Owner Profile</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/admins/editBikeOwnerProfile" method="POST" id="userInterface">
            <input type="hidden" name="bikeOwner_id" value="<?php echo $data['userDetailObject']->bikeOwnerID;?>" id="bikeOwnerID">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">Edit Bike Owner</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/admins/bicycleOwner'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Update" >
                    </div>
                </div>

            </div>

            <div class="data__area--detail">

                <div class="data__area__detail--name">

                    <div class="data__area__div data--firstname">
                        <div class="data--name--lebal">First Name</div>
                        <input type="text" class="detailbox" name="first_name" value="<?php echo $data['userDetailObject']->firstName;?>" id="fName">
                        <br><span class="error_text"><?php echo $data['fName_err'];?></span>
                    </div>

                    <div class="data__area__div data--lastname">
                        <div class="data--name--lebal">Last Name</div>
                        <input type="text" class="detailbox" name="last_name" value="<?php echo $data['userDetailObject']->lastName;?>" id="lName">
                        <br><span class="error_text"><?php echo $data['lName_err'];?></span>
                    </div>

                </div>

                <div class="data__area__detail--email">
                    <div class="data--email--lebal">Email Address</div>
                    <input type="email" class="detailbox detailbox--email" name="email" value="<?php echo $data['userDetailObject']->emailAdd;?>" id="email">
                    <br><span class="error_text"><?php echo $data['email_err'];?></span>
                </div>

                <div class="data__area__detail--number">
                    <div class="data__area__detail--nic_number">
                        <div class="data--name--lebal">NIC Number</div>
                        <input type="text" class="detailbox" name="nic_number" value="<?php echo $data['userDetailObject']->NIC;?>" id="fName">
                        <br><span class="error_text"><?php echo $data['nic_err'];?></span>
                    </div>
                    <div class="data__area__detai--contact_number">
                        <div class="data--name--lebal">Contact Number</div>
                        <input type="text" class="detailbox" name="contact_number" value="<?php echo $data['userDetailObject']->phoneNumber;?>" id="contact_number">
                        <br><span class="error_text"><?php echo $data['pNumber_err'];?></span>
                    </div>
                </div>

            </div>
        </form>        
    </section>



</body>
</html>