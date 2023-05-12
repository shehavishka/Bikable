<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png"> -->
    <style>

        @font-face {
            font-family: 'sfy-regular';
            src:url('<?php echo URLROOT;?>/public/fonts/SF-Pro-Rounded-Regular.otf');
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 10;
            top: 0;
            left: 0;
            background-color: #fff;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .normal{
            top: 0;
            height: 100%;
            width: 100%;
            position: fixed;
            z-index: 9;
            display: none;
            backdrop-filter: blur(5px) opacity(0);
            transition: backdrop-filter 2s, opacity 2s;
        }

        .normal.blur{
            display: block;
            backdrop-filter: blur(5px) opacity(1);
            transition: backdrop-filter 2s, opacity 2s;
            background-color: rgba(0,0,0,0.4);
            /* overscroll-behavior: contain; */
            overflow: hidden;
        }

        .sidenav a {
            padding: 8px 8px 8px 32px;
            text-decoration: none;
            font-size: 16px;
            color: #000;
            display: block;
            transition: 0.3s;
        }

        /* .sidenav a:hover {
            color: #f1f1f1;
        } */

        .sidenav a:active {
            color: #f1f1f1;
        }

        .sidenav .closebtn {
            position: absolute;
            top: 15px;
            right: 25px;
            font-size: 36px;
            /* margin-left: 50px; */
        }

        #menu{
            display: block;
            max-width: 100%;
            margin: 20px;
            cursor:pointer;
        }

        .item{
            display: flex;
            flex-direction: row;
            align-items: center;
            /* padding: 10px; */
            min-width:200px;
        }

        .item.i1{padding-left: 2px;}
        .item.i2{padding-left: 0px;}
        .item.i3{padding-left: 0px;}
        .item.i4{padding-left: 3px;}
        .item.i5{padding-left: 0px;}
        .item.i6{padding-left: 0px;}

        hr{
            border: none;
            width: 85%;
            border-top: 1px solid #D9D9D9;
            margin: 0 auto;
            padding-bottom: 50px;
        }

        .main_title{
            display: inline-block;
            font-size: 1.7rem;
            font-weight: bold;
            padding-bottom: 10px;
            padding-left: 30px;
            min-width:200px;
        }

        #top_part{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 60px;
            padding-left: 25px;
        }

        @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
        }
    </style>
</head>

<div id="overlay" class="normal"></div>

<div id="mySidenav" class="sidenav">
    <div id="top_part">
        <img style="position:absolute;top:35px;width:166px;min-width:166px;display:inline-block;" src="<?php echo URLROOT;?>/public/images/z_bikableLogo/logo1.png" alt="menu">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    </div>
    <div class="main_title">Hello <span style="font-weight: bold;"><?php echo $_SESSION['user_fName']; ?></span></div>
    <hr>
    <a href="<?php echo URLROOT;?>/riders/activeRide"><div class="item i1"><img style="padding:0;margin-right:25px;" src="<?php echo URLROOT;?>/public/images/general/currentIcon.png" alt="menu">Current Ride</div></a>
    <a href="<?php echo URLROOT;?>/riders/viewHistory"><div class="item i2"><img style="padding:0;margin-right:20px;" src="<?php echo URLROOT;?>/public/images/general/historyIcon.png" alt="menu">Ride History</div></a>
    <a href="<?php echo URLROOT;?>/riders/profilePage"><div class="item i3"><img style="padding:0;margin-right:22px;" src="<?php echo URLROOT;?>/public/images/general/userIcon.png" alt="menu">View Profile</div></a>
    <a href="#"><div class="item i4"><img style="padding:0;margin-right:25px;" src="<?php echo URLROOT;?>/public/images/general/cardIcon.png" alt="menu">Wallet</div></a>
    <a href="<?php echo URLROOT;?>/riders/viewReports"><div class="item i5"><img style="padding:0;margin-right:22px;" src="<?php echo URLROOT;?>/public/images/general/reportIcon.png" alt="menu">Make a Report</div></a>
    <a href="<?php echo URLROOT;?>/users/logout"><div class="item i6"><img style="padding:0;margin-right:20px;" src="<?php echo URLROOT;?>/public/images/general/logoutIcon.png" alt="menu">Logout</div></a>
</div>

<span style="font-size:30px;cursor:pointer;" onclick="openNav()">
    <div id="menu"><img src="<?php echo URLROOT;?>/public/images/general/menu.png" alt="menu"></div>
</span>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "317px";
        //change class of verlay to blur
        let overlay = document.getElementById("overlay");
        overlay.classList.add("blur");

    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
        let overlay = document.getElementById("overlay");
        overlay.classList.remove("blur");
    }
</script>