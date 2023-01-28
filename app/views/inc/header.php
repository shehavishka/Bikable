<head>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/inc/header.css"> 
</head>
<section class="dashboard--header">
            <div class="dashboard__header--search">
                <input type="text" class="dashboard__header--searchbox" name="dashboard--searchbox" placeholder="Search">
                <div class="dashboard__header--searchicon">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/search.png" alt="search icon" class="dashboard__icon searchicon">
                </div>
            </div>

            <div class="dashboard__header--helpsetting">
                <div class="helpsetting__help">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/question.png" alt="help" class="dashboard__icon">
                </div>
                <div class="helpsetting__setting">
                    <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/setting.png" alt="setting" class="dashboard__icon">
                </div>
            </div>

            <div class="dashboard__user__detail">
                <div class="user__address">Hello, <?php echo $_SESSION['user_fName'];?></div>
                <!-- <img src="<?php echo URLROOT;?>/public/images/owners/dashboardIcons/avatar.png" alt="dashboard profile picture" class="imgProperty"> -->
                <div class="dropdown_area">
                    <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($_SESSION['user_picture']).'" alt="dashboard profile picture" class="imgProperty"'; ?>
                </div>
                <div class="dashboard__user__dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                    <a href="<?php echo URLROOT ?>/users/logout">Logout</a>
                </div>
            </div>      
</section>