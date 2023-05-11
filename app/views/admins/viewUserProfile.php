<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/viewReport.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>User</title>
</head>
<body>
    <!-- finalized side bar -->
    <?php require APPROOT . '/views/inc/sidebar-admin.php'; ?>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header-admin.php'; ?>

        <!-- REAL DATA AREA -->
        <form action="<?php echo URLROOT;?>/admins/suspendUser" method="POST" id="userInterface">
            <input type="hidden" name="userIdentity" value="<?php echo $data['userDetailObject']->userID;?>" id="userID">
            <input type="hidden" name="userStatus" value="<?php echo $data['userDetailObject']->status;?>">
            <input type="hidden" name="userRole" value="<?php echo $data['userDetailObject']->role;?>">
            <!-- admin real data top -->
            <div class="data__area--top">
                <div class="data__area__top--title">View 
                    <?php 
                        if($data['userDetailObject']->role == 'Mechanic' || $data['userDetailObject']->role == 'mechanic'){
                            echo 'Mechanic';
                        }else{
                            echo 'Rider';
                        }
                    ?>
                </div>
                <div class="data_area__top--twobuttons">
                    <div class="add_user_button">
                        <input type="button" class="btn btn_add" value="Back" onclick="location.href='<?php echo URLROOT;?>/admins/<?php 
                                if($data['userDetailObject']->role == 'Mechanic' || $data['userDetailObject']->role == 'mechanic'){
                                    echo 'mechanic';
                                }else{
                                    echo 'riders';
                                }
                            ?>
                        '">
                    </div>
                    <div class="delete_user_button">
                        <input type="submit" class="btn btn_delete" value="<?php if($data['userDetailObject']->status == 0){echo "Suspend";}else{echo "Activate";} ?>">
                    </div>
                </div>

            </div>

            <div class="data__area--detail">
                
                <div class="data__area__detail--reportID">
                        <div class="data--name--label">User ID: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->userID; ?></div>
                </div>

                <div class="data__area__detail--reporterID">
                        <div class="data--name--label">Last logged in: </div>
                        <!-- <div class="data--name--content">2023-02-12</div> -->
                        <div class="data--name--content"><?php 
                            if($data['userDetailObject']->lastLoggedIn == null){
                                echo "Not logged in yet";
                            }else{
                                echo $data['userDetailObject']->lastLoggedIn;
                            }
                        ?></div>
                </div>

                <div class="data__area__detail--reportID">
                        <div class="data--name--label">Registered date: </div>
                        <!-- <div class="data--name--content">2023-02-12</div> -->
                        <div class="data--name--content"><?php echo $data['userDetailObject']->registeredDate; ?></div>
                </div>

                <div class="data__area__detail--reporterID">
                        <div class="data--name--label">Name: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->firstName . ' ' . $data['userDetailObject']->lastName; ?></div>
                </div>

                <div class="data__area__detail--reporterID">
                        <div class="data--name--label">Status: </div>
                        <div class="data--name--content">
                            <?php 
                                if($data['userDetailObject']->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                } 
                            ?>
                        </div>
                </div>

                <div class="data__area__detail--reporterID">
                        <div class="data--name--label">NIC: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->NIC;?></div>
                </div>
                
                <div class="data__area__detail--problemTitle">
                        <div class="data--name--label">Role: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->role;?></div>
                </div>

                <div class="data__area__detail--loggedTimestamp">
                        <div class="data--name--label">Phone Number: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->phoneNumber;?></div>
                </div>

                <div class="data__area__detail--loggedTimestamp">
                        <div class="data--name--label">Email Address: </div>
                        <div class="data--name--content"><?php echo $data['userDetailObject']->emailAdd;?></div>
                </div>
                
            </div>

        </form>