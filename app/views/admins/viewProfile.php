<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/adminViewProfile.css">
    <title>Owner Profile</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>



    <!-- In the framework right side of the web page view -->
    <section class="admin_data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="admin__data__area--top">
            <div class="admin__data__area__top--title">User Profile</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Edit" onclick="location.href='<?php echo URLROOT;?>/owners/ownerEditsHisNewDetails'">
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
                        ?>); width: 200px; height: 200px; margin-left: 10%;">
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
                <div class="detail__view--card">
                    <!-- <div class="generalInformation"><strong><h2>General Information</h2></strong></div> -->
                    <div class="user__detail">
                        <div class="user_detail_x">
                            <label>Name</label>
                            <div class="user__name">
                                <?php echo($data['userDetailObject']->firstName . " " . $data['userDetailObject']->lastName); ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Mobile Number</label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_pNumber'];?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Email</label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_email'];?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>NIC</label>
                            <div class="user__data">
                                <?php echo $_SESSION['user_NIC'];?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Status</label>
                            <div class="user__data">
                                <?php 
                                    if($_SESSION['user_status'] == 1){
                                        echo "Active";
                                    }else{
                                        echo "Inactive";
                                    }
                                
                                ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Role</label>
                            <div class="user__data">
                                <?php
                                    echo $_SESSION['user_role'];
                                ?>
                            </div>
                        </div>
                        
                    </div>
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