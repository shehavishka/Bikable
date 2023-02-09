<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/addUser.css">
    <title>Add User</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/admins/addUserToTheSystemFormSubmitButton" method="POST" id="userInterface">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">Add User</div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/admins/mechanic'">
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

                <div class="data__area__detail--status">
                    <div class="data--name--lebal">Status</div>
                    <div class="data__status">
                        <div class="data__status--active">
                            <input type="radio" id="active" name="status" value="1" checked>
                            <label for="active">Active</label>
                        </div>
                        <div class="data__status--inactive">
                            <input type="radio" id="inactive" name="status" value="0" >
                            <label for="inactive">Inactive</label>
                        </div>
                    </div>
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

                <div class="data__area__detail--role">
                    <div class="data--name--lebal">Role</div>
                    <input type="text" class="detailbox_userrole detailbox" name="user_role" placeholder="Role" id="userRole" list="roles">
                    <datalist id="roles">
                        <option value="Administrator">
                        <option value="Mechanic">
                        <option value="Rider">
                    </datalist>
                    <span style="color: red;"><?php echo $data['userRole_err'];?></span>
                </div>

            </div>
        </form>        
    </section>



</body>
</html>