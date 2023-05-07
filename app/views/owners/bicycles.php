<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/bicycles.css">
    <title>Bicycles</title>
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
            <div class="admin__data__area__top--title">Bicycles</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Bicycle" onclick="location.href='<?php echo URLROOT;?>/owners/addBicycle'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table>
                <tr>
                    <th style="width: 4%;"></th>
                    <th style="width: 10%;">Bicycle ID</th>
                    <th style="width: 5%;">F.Size</th>
                    <th style="width: 8%;">Status</th>
                    <th style="width: 8%;">Date Accq.</th>
                    <th style="width: 8%;">Deploy Date</th>
                    <th style="width: 8%;">Total KM</th>
                    <th style="width: 10%;">Current Location</th>
                    <th style="width: 8%;">B.OwnerID</th>
                    <!-- <th style="width: 10%;">Log ID</th> -->
                    <th style="width: 5%;"></th>

                </tr>

                <!-- sample template data -->
                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>37116D</td>
                    <td>L</td>
                    <td>Inactive</td>
                    <td>2022.12.27</td>
                    <td>2023.12.24</td>
                    <td>43</td>
                    <td>COL8B</td>
                    <td>2124</td>
                    <td>M23098</td>
                    <td>
                        update icon svg format -->
                        <!-- <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->


                <?php foreach($data['bicycles_details'] as $oneBike) : ?>
                    <tr style="height: 2.5rem;">
                        <td></td>
                        <td><?php echo $oneBike->bicycleID ?></td>
                        <td><?php echo $oneBike->frameSize ?></td>
                        <td>
                            <?php 
                                if($oneBike->status == 1){
                                    echo "Active";
                                }else{
                                    echo "Inactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo $oneBike->dateAcquired ?></td>
                        <td><?php echo $oneBike->datePutInUse ?></td>
                        <td><?php echo $oneBike->totalKM ?></td>
                        <td><?php echo $oneBike->currentLocationLat ? $oneBike->currentLocationLat : "Null" ?></td>
                        <td><?php echo $oneBike->bikeOwnerID ?></td>
                        <td>
                        <!-- update icon svg format -->
                            <form action="<?php echo URLROOT;?>/owners/userProfileViewButton" method="post">
                                <input type="hidden" name="userID" value="<?php echo $oneAdmin->userID;?>">
                                <input type="submit" name="edit" value="edit" >
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </section>



</body>
</html>