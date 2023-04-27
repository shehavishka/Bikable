<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/ownerChangesHisPassword.css">
    <title>Owner Edit Profile</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">Change Password</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Edit" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div> -->
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/owners/ownerEditsHisOwnProfile'">
                </div>
            </div>

        </div>

        <section class="data__area">
            <!-- <div class="left--side">
                <div class="profile__picture--card">
                    <div> 
                        <h1>Image</h1>
                    </div>
                    <div class="user_history">
                        <div class="user_detail_x">
                            <label>User ID</label>
                            <div class="user__data">
                                12582
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Last Logged In</label>
                            <div class="user__data">
                                2022/10/10
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Registered Date</label>
                            <div class="user__data">
                                2020/10/24
                            </div>
                        </div>
                    </div>
    
                </div>
            </div> -->


            <div class="right--side">

                    <div class="detail__view--card">
                        <div class="generalInformation"><strong><h3>Update your password to keep your account secure.</h3></strong></div>
                        <form>
                            <div class="current_password password_div_section">
                                <label for="current-password" style="margin-right: 7.5%;">Current Password:</label> 
                                <input type="password" id="current-password" name="current-password" required class="signupDetailbox">
                            </div>

                            <div class="new_Password password_div_section">
                                <label for="new-password" style="margin-right: 9.4%;">New Password:</label>
                                <input type="password" id="new-password" name="new-password" required class="signupDetailbox">
                            </div>

                            <div class="confirm_password password_div_section">
                                <label for="confirm-password" style="margin-right: 3%;">Confirm New Password:</label>
                                <input type="password" id="confirm-password" name="confirm-password" required class="signupDetailbox">
                            </div>
               
                            <div class="button__area">
                                <input type="submit" value="Change Password" class="btn" style="margin-left: 20%;">
                            </div>
                        </form>
                    </div>
                <!-- <div class="button__area">
                    <form action="" method="post">
                        <input type="hidden" name="userIdentity" value="">
                        <input type="submit" value="Suspend" class="btn">
                    </form>
                </div> -->
            </div>
        </section>
            
        </div>
    </section>
</body>
</html>