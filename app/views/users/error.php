<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/error.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Error404</title>
</head>
<body>
    <div class="box">
        <div class="box__title">
            Oops! Technical Difficulties
        </div>
        <div class="box__image">
            <img src="<?php echo URLROOT;?>/public/images/z_errorImages/500InternalServerError.png" alt="BikableLogo" class="serverImage">
        </div>
        <div class="box__goBack_button">
            <input type="button" value="Go back" class="btn" onclick="goBack()">

            <script>
                function goBack() {
                    window.history.back();
                }
            </script>

        </div>
    </div>
    
</body>
</html>