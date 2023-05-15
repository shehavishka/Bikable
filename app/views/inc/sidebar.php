    <!-- finalized side bar -->
    <head>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/inc/sidebar.css"> 
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                    <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/ownerLandPage">Dashboard</a></div>
                </div>
                <hr>
                <div class="detail detail__users">
                    <div class="detail__users--title">
                        Users
                    </div>
                    <div class="detail__users--submenu">
                        <div class="submenu users__submenu--mechanic">
                            <a href="<?php echo URLROOT ?>/owners/mechanic">Mechanic</a>
                        </div>
                        <div class="submenu users__submenu--riders">
                            <a href="<?php echo URLROOT ?>/owners/riders">Riders</a>
                        </div>
                        <div class="submenu users__submenu--bicycleOwners">
                            <a href="<?php echo URLROOT ?>/owners/bicycleOwner">Bicycle Owner</a>
                        </div>
                        <div class="submenu users__submenu--administrators">
                            <a href="<?php echo URLROOT ?>/owners/administrator">Administrator</a>
                        </div>
                    </div>
                </div>
                <hr>
                <!-- <div class="detail detail__repairLog">
                    <div class="detail__repairlog--title">
                    <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/repairLog">Repair Log</a></div>
                    </div>
                </div> -->
                <!-- <hr> -->
                <div class="detail detail__dockingAreas">
                    <div class="detail__dockingAreas--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/dockingAreas">Docking Areas</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__bicycles">
                    <div class="detail__bicycles--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/bicyclesControl">Bicycles</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__rides">
                    <div class="detail__rides--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/ridesControl">Rides</a></div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__reports">
                    <div class="detail__reports--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/reportsControl">Reports</a></div>
                    </div>
                    <div class="detail__reports--submenu">
                    <div class="detail__reports--submenu">
                        <div class="submenu reports__submenu--accidentReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/AccidentReportsControl">Accident Reports</a></div>
                        </div>
                        <div class="submenu users__submenu--bikeComplaintReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/BicycleReportsControl">Bike Reports</a></div>
                        </div>
                        <div class="submenu users__submenu--dockingAreaReport">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/DAReportsControl">Docking Area Reports</a></div>
                        </div>
                    </div>
                    </div>
                </div>
                <hr>
                <div class="detail detail__statics">
                    <div class="detail__static--title">
                        <div class="detail__dashboard--name" ><a href="<?php echo URLROOT ?>/owners/statisticsPageView">Statistics</a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>