<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/admins/viewUserProfile.css">
    <title>User Profile</title>
</head>
<body>
    <section class="data__area">
        <div class="left--side">
            <div class="profile__picture--card">
                <div class="dropdown_area" style="background-image: url(
                        <?php 
                            if($data['userDetailObject']->userPicture != null){
                                echo URLROOT. "/public/images/profile_pictures/". $data['userDetailObject']->userPicture . ".jpg";
                            }else{
                                echo URLROOT. "/public/images/z_bikableLogo/logo.PNG";
                            }
                        ?>);">
                </div>
                <div class="user_history">
                    <table>
                        <tr>
                            <th style="width: 3%;"></th>
                            <th style="width: 5%;"></th>
        
                        </tr>
                        <tr>
                            <td>User ID</td>
                            <td><?php echo $data['userDetailObject']->userID; ?></td>
                        </tr>
                        <tr>
                            <td>Last Logged in  :</td>
                            <td>2023/02/5</td>
                        </tr>
                        <tr>
                            <td>Registered date : </td>
                            <td>2022/12/28</td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>
        <div class="right--side">
            <div class="detail__view--card">
                <div class="generalInformation"><strong><h2>General Information</h2></strong></div>
                <div class="user__detail">
                    <table>
                        <tr>
                            <td>Name</td>
                            <td><?php echo $data['userDetailObject']->firstName . ' ' . $data['userDetailObject']->lastName; ?></td>
                        </tr>
                        <tr>
                            <td>NIC</td>
                            <td><?php echo $data['userDetailObject']->NIC; ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td><?php echo $data['userDetailObject']->role; ?></td>
                        </tr>
                        <tr>
                            <td>Mobile Number</td>
                            <td><?php echo $data['userDetailObject']->phoneNumber; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $data['userDetailObject']->emailAdd; ?></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>
                                <?php
                                    if($data['userDetailObject']->status == 1){
                                        echo "Active";
                                    }else{
                                        echo "Inactive";
                                    }
                                ?>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="button__area">
                <form action="<?php echo URLROOT;?>/admins/suspendUser" method="post">
                    <input type="hidden" name="userIdentity" value="<?php echo $data['userDetailObject']->userID;?>">
                    <input type="hidden" name="userStatus" value="<?php echo $data['userDetailObject']->status;?>">
                    <input type="submit" value=<?php if($data['userDetailObject']->status == 1){echo "Suspend";}else{echo "Activate";} ?> class="btn">
                </form>
            </div>
        </div>
    </section>


</body>
</html>