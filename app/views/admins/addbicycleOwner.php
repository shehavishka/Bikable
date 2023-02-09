<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/addUser.css">
    <title>Add Bicycle Owner</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/admins/addBikeOwnerToTheSystemFormSubmitButton" method="POST" id="userInterface">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">Add Bike Owner</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/admins/bicycleOwner'">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="Submit" >
                    </div>
                </div>

            </div>

            <div class="data__area--detail">

                <div class="data__area__detail--name">

                    <div class="data__area__div data--firstname">
                        <div class="data--name--lebal">First Name</div>
                        <input type="text" class="detailbox" name="first_name" placeholder="First name" id="fName">
                        <span style="color: red;"><?php echo $data['fName_err'];?></span>
                    </div>

                    <div class="data__area__div data--lastname">
                        <div class="data--name--lebal">Last Name</div>
                        <input type="text" class="detailbox" name="last_name" placeholder="Last name" id="lName">
                        <span style="color: red;"><?php echo $data['lName_err'];?></span>
                    </div>

                </div>

                <div class="data__area__detail--email">
                    <div class="data--email--lebal">Email Address</div>
                    <input type="email" class="detailbox detailbox--email" name="email" placeholder="Email" id="email">
                    <span style="color: red;"><?php echo $data['email_err'];?></span>
                </div>

                <div class="data__area__detail--number">
                    <div class="data__area__detail--nic_number">
                        <div class="data--name--lebal">NIC Number</div>
                        <input type="text" class="detailbox" name="nic_number" placeholder="NIC Number" id="fName">
                        <span style="color: red;"><?php echo $data['nic_err'];?></span>
                    </div>
                    <div class="data__area__detai--contact_number">
                        <div class="data--name--lebal">Contact Number</div>
                        <input type="text" class="detailbox" name="contact_number" placeholder="Contact Number" id="contact_number">
                        <span style="color: red;"><?php echo $data['pNumber_err'];?></span>
                    </div>
                </div>

            </div>
        </form>        
    </section>



</body>
</html>