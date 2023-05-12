<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/signup.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Signup</title>
</head>
<body>
    <section class="signupView">
        <div class="signupView__logoSide">
            <div class="signupView__logoSide--imagecard">
            <img src="<?php echo URLROOT;?>/public/images/z_bikableLogo/logo.PNG" alt="BikableLogo" class="imglogo">
            </div>
        </div>

        <div class="signupView___dataSide">
            <!-- header and subtitle -->
            <div class="signupView__title">Create an account</div>
            <div class="signupView__subtitle">You're almost all set to ride.</div>
        
            <!-- user entered details-->
            <form action="<?php echo URLROOT; ?>/users/signup" method="POST">
                <div class="signupView__Detail">
                    <div class="signupView__Detail--data">
                        <input type="text" class="signupDetailbox" name="first_name" placeholder="First name">
                    </div>

                    <div class="signupView__Detail--data">
                        <input type="text" class="signupDetailbox" name="last_name" placeholder="Last name">
                    </div>

                    <div class="signupView__Detail--data">
                        <input type="email" class="signupDetailbox" name="email" placeholder="Email">
                    </div>

                    <div class="signupView__Detail--data">
                        <input type="number" class="signupDetailbox" name="phone_number" placeholder="Phone number">
                    </div>

                    <div class="signupView__Detail--data">
                        <input type="password" class="signupDetailbox" name="password" placeholder="Password">
                    </div>

                    <div class="signupView__Detail--data">
                        <input type="text" class="signupDetailbox" name="nic_number" placeholder="NIC">
                    </div>

                    <!-- <div class="signupView__Detail--data">
                        <input type="text" class="signupDetailbox" name="first_name" placeholder="Confirm Password">
                    </div> -->
                </div>

                <div class="signupButtoCondtionform">
                    <div class="activeArea">
                        <div class="submitbutton">
                            <input type="submit" value="SIGNUP" class="btn" >                  
                        </div>
                        <div class="signupText">
                           <a href="" style="color: black">How will we use your personal information?</a>
                        </div>
                    </div>
                </div>



            </form>
        
        
        </div>
    </section>
    
</body>
</html>
