<!DOCTYPE html>
<html>
<head>
    <title>OTP Entry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <style>
        *,
        *::before,
        *::after{
            box-sizing: border-box;
        }

        /* get local font to the webpage */
        @font-face {
            font-family: 'sfmy-regular';
            src:url('../fonts/SF-Pro-Rounded-Regular.otf');
        }

        :root{
            --clr-dark : #efebeb;
            --clr-light : #fff;

            --fs-h1 : 3rem;
            --fs-h2 : 2.25rem;
            --fs-h3 : 1.25rem;
            --fs-body : 1rem;

            --fw-reg : 300;
            --fw-bold : 900;

            --ff-family :  'sfmy-regular',sans-serif;
        }

        @media (min-width : 800px){
            :root{
                --fs-h1 : 4rem;
                --fs-h2 : 3.75rem;
                --fs-h3 : 1.5rem;
                --fs-body : 1.2rem;
            }
        }

        html{
            height: 100%;
        }

        body{
            display: flex;
            /* flex-direction: column; */
            justify-content: center;
            align-items: center;
            height: 100%;
            margin: 0;
            background: var(--clr-light);
            font-family: var(--ff-family);
            font-size: var(--fs-body);
            line-height: 1.5;
        }

        /*control images*/
        img{
            display: block;
            max-width: 100%;
        }

        h1 { font-size: var(--fs-h1);}
        h2 {font-size: var(--fs-h2);}
        h3 {font-size: var(--fs-h3);}

        /*button decoration*/
        .btn{
            border: none;
            /* margin-left: 0%; */
            width: 110px;
            height: 45px;
            color: white;
            background: black;
            border-radius: 13px;
            font-weight: var(--fw-reg);
            letter-spacing: 1px;
            transition: 500ms;
            border-radius: 60px;
            font-family: 'sfmy-regular',sans-serif;
        }

        .btn:hover{
            transform: scale(1.1);
        }

        /*forget text*/
        .forgetText{
            margin-top: 2%;
        }


        /*image decoration*/
        .imglogo{
            transition: 800ms;
        }
        .imglogo:hover{
            transform: scale(1.5);
        }


        /* If we get and invalid input then need to indicate error decoration
        */
        .box{
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            margin-top: 4%;
            /* height: 100vh; Optional: Set the container to fill the viewport */
        }

        .box__title{
            font-size: var(--fs-h3);
            /* margin: 2%; */
            margin-bottom: 20px;
        }

        .box__image{
            width: 25%;
            height: 25%;
            /* background-color:var(--clr-dark); */
            border-radius: 16px;
        }

        .box__goBack_button{
            margin: 3%;
        }

        .formStyle{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

    </style>
</head>
<body>
    <div class="box">
        <div class="box__title">
           Please check your email for the OTP
        </div>
        <form action="<?php echo URLROOT;?>/users/sendOTPtoDb" method="POST" id="userInterface" class="formStyle">
            <input type=hidden name="email" value="<?php echo $data['email'];?>">
            <input type=hidden name="first_name" value="<?php echo $data['first name'];?>">
            <input type=hidden name="last_name" value="<?php echo $data['last name'];?>">
            <input type=hidden name="phone_number" value="<?php echo $data['phone no'];?>">
            <input type=hidden name="years" value="<?php echo $data['years'];?>">
            <input type=hidden name="password" value="<?php echo $data['password'];?>">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required>
            <br><span class="error_text"><?php echo $data['otp_err'];?></span>
            <br>
            <input type="submit" value="Submit" class="btn">
        </form>
    </div>
</body>
</html>
