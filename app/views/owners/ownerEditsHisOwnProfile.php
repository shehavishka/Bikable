<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/ownerEditsHisOwnProfile.css">
    <title>Owner Edit His Profile</title>
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
            <div class="admin__data__area__top--title">User Edits Profile</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="<< Back" onclick="location.href='<?php echo URLROOT;?>/owners/ownerViewsHisOwnProfile'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Change Password" onclick="location.href='<?php echo URLROOT;?>/owners/ownerChangesHisPassword'">
                </div>
            </div>

        </div>

        <section class="data__area">
            <div class="left--side">
                <div class="profile__picture--card">
                    <div class="dropdown_area" style="background-image: url(
                        <?php 
                            if($_SESSION['user_picture'] != null){
                                echo URLROOT. "/public/images/profile_pictures/". $_SESSION['user_picture'];
                            }else{
                                echo URLROOT. "/public/images/z_bikableLogo/logo.PNG";
                            }
                        ?>); width: 200px; height: 200px; margin-left: 0%;">
                    </div>
                    <div class="profile__picture__upload--area" style="margin-top: 4%;">

                        <form class="" action="<?php echo URLROOT;?>/owners/ownerUpdatesHisProfilePicture" method="post" autocomplete="off" enctype="multipart/form-data">
                            <input type="file" name="image1" id = "image1" accept=".jpg, .jpeg, .png" value="">
                            <button type = "submit" name = "submit" class="">Submit</button>
                        </form>

                    </div>
                    <div class="user_history">
                        <div class="user_detail_x">
                            <label>User ID: </label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_ID'];?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Last Logged In</label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_last_logged_in'];?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Registered Date</label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_registered_date'];?>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>

            <div class="right--side">
                <form action="<?php echo URLROOT;?>/owners/ownerEditsHisNewDetails" method="post">
                    <div class="detail__view--card">
                        <!-- <div class="generalInformation"><strong><h2>General Information</h2></strong></div> -->
                        <div class="user__detail">
                            <div class="user_detail_x">
                                <label>First Name</label>
                                <!-- <div class="user__name">
                                    Deshan Perera
                                </div> -->
                                <div class="signupView__Detail--data">
                                    <input type="text" class="signupDetailbox" name="first_name" value="<?php echo $_SESSION['user_fName']; ?>">
                                    <span style="color: red;"><?php echo $data['fName_err'];?></span>
                                </div>
                            </div>
                            <div class="user_detail_x">
                                <label>Last Name</label>
                                <!-- <div class="user__data">
                                    0771691525
                                </div> -->
                                <div class="signupView__Detail--data">
                                    <input type="text" class="signupDetailbox" name="last_name" value="<?php echo $_SESSION['user_lName']; ?>">
                                    <span style="color: red;"><?php echo $data['lName_err'];?></span>
                                </div>
                            </div>
                            <div class="user_detail_x">
                                <label>Email Address</label>
                                <!-- <div class="user__data">
                                    deshan@gmail.com
                                </div> -->
                                <div class="signupView__Detail--data">
                                    <input type="text" class="signupDetailbox" name="email" value="<?php echo $_SESSION['user_email']; ?>" disabled>
                                    <br><span style="color: red;"><?php echo $data['email_err'];?></span>
                                </div>
                            </div>
                            <div class="user_detail_x">
                                <label>NIC</label>
                                <!-- <div class="user__data">
                                    200001558692
                                </div> -->
                                <div class="signupView__Detail--data">
                                    <input type="text" class="signupDetailbox" name="nic_number" value="<?php echo $_SESSION['user_NIC']; ?>">
                                    <br><span style="color: red;"><?php echo $data['nic_err'];?></span>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="button__area">
                            <input type="submit" value="Submit" class="btn">
                    </div>
                </form>
            </div>
        </section>
            
        </div>
    </section>
</body>
</html>