<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/inc/header-admin.css"> 
</head>
<section class="dashboard--header">
            <!-- <div class="dashboard__header--search">
                <input type="text" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">          
                <div class="dashboard__header--searchicon">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
                </div>
            </div> -->

            <div class="dashboard__header--helpsetting" style="margin-left: 1%;">
                <!-- <p id="greeting"></p>
                <p id="time"></p>

                <script>
                    // Set the timezone to the desired value
                    var options = { timeZone: 'Asia/Colombo' };
                    var now = new Date().toLocaleString('en-US', options);
                    now = new Date(now);

                    // Get current time and display personalized greeting
                    var hours = now.getHours();
                    var greeting;
                    if (hours >= 5 && hours < 12) {
                        greeting = "Good Morning!";
                    } else if (hours >= 12 && hours < 18) {
                        greeting = "Good Afternoon!";
                    } else {
                        greeting = "Good Evening!";
                    }

                    var minutes = now.getMinutes();
                    var ampm = hours >= 12 ? 'pm' : 'am';
                    hours = hours % 12;
                    hours = hours ? hours : 12;
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    var currentTime = hours + ':' + minutes + ' ' + ampm;
                    document.getElementById("greeting").innerHTML = greeting;
                    document.getElementById("time").innerHTML =  currentTime;
                </script> -->
            </div>

            <div class="dashboard__user__detail">
                <div class="user__address">Hello, <?php echo $_SESSION['user_fName'];?></div>
                <!-- <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/avatar.png" alt="dashboard profile picture" class="imgProperty"> -->
                
                <div class="dropdown_area" style="background-image: url(
                    <?php 
                        if($_SESSION['user_picture'] != null){
                            echo URLROOT. "/public/images/profile_pictures/". $_SESSION['user_picture'];
                        }else{
                            echo URLROOT. "/public/images/z_bikableLogo/logo.PNG";
                        }
                    ?>);">
                    <div class="dashboard__user__dropdown-content">
                        <a href="<?php echo URLROOT ?>/owners/ownerViewsHisOwnProfile">Profile</a>
                        <!-- <a href="#">Settings</a> -->
                        <a href="<?php echo URLROOT; ?>/users/logout">Logout</a>
                    </div>
                </div>

            </div>      
</section>