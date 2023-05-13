<!DOCTYPE html>
<html>
<head>
    <title>OTP Entry</title>
    <link rel="stylesheet" type="text/css" href="../css/otp.css">
</head>
<body>
    <form action="<?php echo URLROOT; ?>/Users/sendOTPtoDb" method="POST" id="userInterface">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($data['email']); ?>">
        <label for="otp">Enter OTP:</label>
        <input type="text" id="otp" name="otp" required>
        <br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
