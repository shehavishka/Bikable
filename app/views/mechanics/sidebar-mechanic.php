    <!-- finalized side bar -->
    <head>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/inc/sidebar.css"> 
    </head>
    <section class="sidebar">
        <div class="viewData">
            <div class="sidebar--logo">
                <div class="sidebar--logo--img">
                    <img src="<?php echo URLROOT;?>/public/images/z_bikableLogo/logo.PNG" alt="">
                </div>
            </div>
            <div class="sidebar__detail">
                <div class="detail detail__dashboard">
                    <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/mechanicLandPage">Dashboard</a></div>
                </div>
                <hr>
                <div class="detail detail__repairLog">
                    <div class="detail__repairlog--title">
                    <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/repairLogsControl">Repair Log</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__dockingAreas">
                    <div class="detail__dockingAreas--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/dockingAreas">Docking Areas</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__bicycles">
                    <div class="detail__bicycles--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/bicycleControl">Bicycles</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__reports">
                    <div class="detail__reports--title">
                    <!-- Reports -->
                    <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/reportsControl">Reports</a></div>
                    </div>
                    <div class="detail__reports--submenu">
                        <div class="submenu reports__submenu--accidentReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/AccidentReportsControl">Accident Reports</a></div>
                        </div>
                        <div class="submenu users__submenu--bikeComplaintReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/BicycleReportsControl">Bike Reports</a></div>
                        </div>
                        <div class="submenu users__submenu--dockingAreaReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/mechanics/DAReportsControl">Docking Area Reports</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>