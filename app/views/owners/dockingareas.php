<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/dockingareas.css">
    <title>Docking Areas</title>
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
            <div class="admin__data__area__top--title">Docking Areas</div>
            <div class="admin__data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Add Area" onclick="location.href='<?php echo URLROOT;?>/owners/addDockingAreaToSystem'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Delete Selected" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="admin__table__area">
            <table style="margin-left: 0rem; margin-right: 0rem;">
                <tr>
                    <th style="width: 1%;"></th>
                    <th style="width: 1%;">Area ID</th>
                    <th style="width: 3%;">Area Name</th>
                    <th style="width: 3%;">Status</th>
                    <th style="width: 4%;">Address</th>
                    <th style="width: 2%;">Current Bikes</th>
                    <!-- <th style="width: 8%;">Mechanic ID</th> -->
                    <!-- <th style="width: 4%;">Log ID</th> -->
                    <th style="width: 1%;"></th>

                </tr>

                <!-- sample template data -->
                <!-- <tr>
                    <td><input type="checkbox" class="cbox"></td>
                    <td>KALB</td>
                    <td>18</td>
                    <td>Inactive</td>
                    <td>E6.8962° N, 79.8571° E</td>
                    <td>M5322</td>
                    <td>M32465</td>
                    <td> -->
                        <!-- update icon svg format -->
                        <!-- <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="17" cy="17" r="17" fill="black"/>
                            <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                        </svg>
                            
                    </td>
                </tr> -->
               
                <?php foreach($data['docking_areas_details'] as $oneDoc) : ?>
                    <tr>
                        <td><input type="checkbox" class="cbox"></td>
                        <td><?php echo $oneDoc->areaID;?></td>
                        <td><?php echo $oneDoc->areaName;?></td>
                        <td>
                            <?php 
                                if($oneDoc->status == 0){
                                    echo "Active";
                                }else{
                                    echo "Deactive";
                                }
                            
                            ?>
                        </td>
                        <td><?php echo "E" . round($oneDoc->locationLat,4) ."° N, ". round($oneDoc->locationLong,4) ."° E" ?></td>
                        <td><?php echo $oneDoc->currentNoOfBikes;?></td>
                        <td>
                            <!-- update icon svg format -->
                            <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="17" cy="17" r="17" fill="black"/>
                                <path d="M19.06 14L20 14.94L10.92 24H10V23.08L19.06 14ZM22.66 8C22.41 8 22.15 8.1 21.96 8.29L20.13 10.12L23.88 13.87L25.71 12.04C26.1 11.65 26.1 11 25.71 10.63L23.37 8.29C23.17 8.09 22.92 8 22.66 8ZM19.06 11.19L8 22.25V26H11.75L22.81 14.94L19.06 11.19Z" fill="white"/>
                            </svg>
                                
                        </td>
                    </tr>

                <?php endforeach; ?>

            </table>
        </div>
    </section>



</body>
</html>