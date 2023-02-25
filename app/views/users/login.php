<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/login.css">
    <title>Login</title>
</head>
<body>
    <section class="loginView">
        
        <form action="<?php echo URLROOT; ?>/users/login" method="POST" id="loginInterface" class="loginInterface">
            <div class="loginView__dataSide">
                <!-- Header and subtitle -->
                <div class="loginView__title">Welcome to Bikable</div>
                <div class="loginView__subtitle">Please login to use the platform</div>

                <!-- email and password form -->
                <div class="loginView__Detail">
                    <div class="loginDetail--email">
                        <input type="email" placeholder="Email" class="loginDetailbox" name="userEmail" id="loginEmailBox" value="<?php echo  $data['email'] ?>">
                        <!-- display error email message -->
                        <span style="color: red;"><?php echo $data['email_err'];?></span>
                    </div>
                    <div class="loginDetail--password">
                        <input type="password" placeholder="Password" class="loginDetailbox" name="userPassword" id="passwordEmailbox" value="<?php echo $data['password'] ?>">
                        <!-- display error password message -->
                        <span style="color: red;"><?php echo $data['password_err']; ?></span>
                    </div>   
                </div>

                <!-- submit button , link to sign up page and reset process -->
                <div class="submitSignupForget">
                    <div class="activeArea">
                        <div class="submitbutton">
                            <input type="submit" value="LOGIN" class="btn">                  
                        </div>
                        <div class="signupText">
                            <!-- sign up button should be add here -->
                            Don't have an account? <a href="<?php echo URLROOT;?>/users/register" style="color: blue;"></a> 
                        </div>
                    </div>
                    <div class="forgetText">
                        Can't remember password? <a href="" style="color: black;">Reset password</a> 
                    </div>
                </div>
            </div>
        </form>
        
        <!-- logo image -->
        <div class="loginView__logoSide">
            <img src="<?php echo URLROOT;?>/public/images/z_bikableLogo/logo.PNG" alt="BikableLogo" class="imglogo">
        </div>
    </section>
</body>
</html>