<!DOCTYPE html>
<html>
<head>
    <title>OTP Entry</title>
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
</head>
<body>
    <!-- <form method="POST" action="Users"> -->
        <form action="<?php echo URLROOT;?>/Users/sendOTPtoDb" method="POST" id="userInterface">
        <input type=hidden name="email" value="<?php echo $data['email'];?>">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
