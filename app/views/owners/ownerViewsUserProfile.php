<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/ownerViewsUserProfile.css">
    <title>User Profile</title>
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
            <div class="admin__data__area__top--title">User Profile</div>
            <div class="admin__data_area__top--twobuttons">
                <!-- <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Edit" onclick="location.href='<?php echo URLROOT;?>/owners/ownerEditsHisOwnProfile'">
                </div> -->
                <div class="delete_user_button">
                    <input type="button" value="Go back" class="btn" onclick="goBack()">
                    <script>
                        function goBack(){
                            window.history.back();
                        }
                    </script>
                </div>
            </div>

        </div>

        <section class="data__area">
            <div class="left--side">
                <div class="profile__picture--card">
                    <div class="dropdown_area" style="background-image: url(
                        <?php 
                            if($data['userDetailObject']->userPicture != null){
                                echo URLROOT. "/public/images/profile_pictures/". $data['userDetailObject']->userPicture;
                            }else{
                                echo URLROOT. "/public/images/z_bikableLogo/logo.PNG";
                            }
                        ?>); width: 200px; height: 200px; margin-left: 10%;">
                    </div>
                    <div class="user_history">
                        <div class="user_detail_x">
                            <label>User ID: </label>
                            <div class="user__data">
                                <?php echo $data['userDetailObject']->userID ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Last Logged In</label>
                            <div class="user__data">
                                <?php 
                                    if($_SESSION['user_last_logged_in'] == NULL){
                                        echo "-";
                                    }else{
                                        echo $_SESSION['user_last_logged_in'];
                                    }
                                ?>
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
                                <?php echo $data['userDetailObject']->firstName . ' ' . $data['userDetailObject']->lastName; ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Mobile Number</label>
                            <div class="user__data">
                                <?php echo $data['userDetailObject']->phoneNumber; ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Email</label>
                            <div class="user__data">
                                <?php echo $data['userDetailObject']->emailAdd; ?>
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>NIC</label>
                            <div class="user__data">
                                <?php echo $data['userDetailObject']->NIC; ?>   
                            </div>
                        </div>
                        <div class="user_detail_x">
                            <label>Status</label>
                            <div class="user__data">
                                <?php
                                    if($data['userDetailObject']->status == 0){
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
                                    echo $data['userDetailObject']->role;
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="button__area">
                    <form action="<?php echo URLROOT;?>/owners/suspendReleaseUser" method="post">
                        <input type="hidden" name="userIdentity" value="<?php echo $data['userDetailObject']->userID;?>">
                        <input type="hidden" name="userStatus" value="<?php echo $data['userDetailObject']->status;?>">
                        <button type="submit" class="btn btnSuspendRelease">
                            <?php
                                if($data['userDetailObject']->status == 1){
                                    echo "Release";
                                }else{
                                    echo "Suspend";
                                }
                            ?>
                        </button>
                    </form>
                </div>
            </div>
        </section>
            
        </div>


</body>
</html>