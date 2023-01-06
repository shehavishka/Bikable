<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/owners/addNewRepairLog.css">
    <title>New Log</title>
</head>
<body>
    <!-- finalized side bar -->
    <section class="sidebar">
        <div class="viewData">
            <div class="sidebar--logo">
                <div class="sidebar--logo--img">
                    <img src="images/bikableLogo/logo.PNG" alt="">
                </div>
            </div>
            <div class="sidebar__detail">
                <div class="detail detail__dashboard">
                    Dashboard
                </div>
                <hr>
                <div class="detail detail__users">
                    <div class="detail__users--title">
                        Users
                    </div>
                    <div class="detail__users--submenu">
                        <div class="submenu users__submenu--mechanic">
                            Mechanic
                        </div>
                        <div class="submenu users__submenu--riders">
                            Riders
                        </div>
                        <div class="submenu users__submenu--bicycleOwners">
                            Bicycle Owners
                        </div>
                        <div class="submenu users__submenu--administrators">
                            Administrators
                        </div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__repairLog">
                    <div class="detail__repairlog--title">
                        Repair Log
                    </div>
                </div>
                <hr>
                <div class="detail detail__dockingAreas">
                    <div class="detail__dockingAreas--title">
                        Docking Areas
                    </div>
                </div>
                <hr>
                <div class="detail detail__bicycles">
                    <div class="detail__bicycles--title">
                        Bicycles
                    </div>
                </div>
                <hr>
                <div class="detail detail__rides">
                    <div class="detail__rides--title">
                        Rides
                    </div>
                </div>
                <hr>
                <div class="detail detail__reports">
                    <div class="detail__reports--title">
                        Reports
                    </div>
                    <div class="detail__reports--submenu">
                        <div class="submenu reports__submenu--accidentReport">
                            Accident Reports
                        </div>
                        <div class="submenu users__submenu--bikeComplaintReport">
                            Bike Complaint Reports
                        </div>
                        <div class="submenu users__submenu--dockingAreaReport">
                            Docking Area Reports
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- In the framework right side of the web page view -->
    <section class="data_area">

        <!-- dashboard section -->
        <?php require APPROOT . '/views/inc/header.php'; ?>

        <!-- REAL DATA AREA -->

        <!-- admin real data top -->
        <div class="data__area--top">
            <div class="data__area__top--title">New Log</div>
            <div class="data_area__top--twobuttons">
                <div class="add_user_button">
                    <input type="button" class="btn btn_add" value="Cancel" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
                <div class="delete_user_button">
                    <input type="button" class="btn btn_delete" value="Submit" onclick="location.href='<?php echo URLROOT;?>/owners/addAdministrator'">
                </div>
            </div>

        </div>

        <div class="data__area--detail">

            <div class="data__area__div data--reportID">
                <div class="data--name--lebal">Report ID</div>
                <input type="text" class="detailbox" placeholder="Report ID" id="fName">
            </div>

            <div class="data__area__div data--repairLogID">
                <div class="data--name--lebal">Repair Log ID</div>
                <input type="text" class="detailbox"  placeholder="Repair Log ID" id="fName">
            </div>

            <div class="data__area__div data--bicycleID">
                <div class="data--name--lebal">Bicycle ID</div>
                <input type="text" class="detailbox"  placeholder="Bicycle ID" id="fName">
            </div>

            <div class="data__area__div data--problemTitle">
                <div class="data--name--lebal">Problem Title</div>
                <input type="text" class="detailbox__problemtitle detailbox" placeholder="Problem ID" id="fName">
                <!-- <textarea name="" id="fName" class="detailbox" cols="30" rows="5" placeholder="Problem Title"></textarea> -->
            </div>

            <div class="data__area__div data--dateIn">
                <div class="data--name--lebal">Date In</div>
                <input type="text" class="detailbox" placeholder="Date In" id="fName">
            </div>

            <div class="data__area__div data--dateOut">
                <div class="data--name--lebal">Date Out</div>
                <input type="text" class="detailbox" placeholder="Date Out" id="fName">
            </div>

            <div class="data__area__div data--mechanicID">
                <div class="data--name--lebal">Mechanic ID</div>
                <input type="text" class="detailbox" placeholder="Mechanic ID" id="fName">
            </div>

            <div class="data__area__div data--repairDescription">
                <div class="data--name--lebal">Repair Description</div>
                <!-- <input type="text" class="detailbox" placeholder="Repair Description" id="fName"> -->
                <textarea name="" id="fName" class="detailbox" cols="30" rows="7" placeholder="Repair Description"></textarea>
            </div>

            <div class="data__area__div data--estimatedCost">
                <div class="data--name--lebal">Estimated Cost</div>
                <input type="text" class="detailbox" placeholder="Estimated Cost" id="fName">
            </div>

            <div class="data__area__div data--finalCost">
                <div class="data--name--lebal">Final Cost</div>
                <input type="text" class="detailbox" placeholder="Final Cost" id="fName">
            </div>

        </div>
    </section>



</body>
</html>