<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/riders/viewProfile.css">
    <link rel="icon" href="<?php echo URLROOT;?>/public/images/general/favicon.png">
    <title>Wallet</title>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        html{
            height: 100%;
        }

        body{
            height: 80%;
        }

        #container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 100%;
            width: 100%;
            padding-left: 5%;
            padding-right: 5%;
        }

        #upper_section{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            padding: 1%;
            margin-top: 70.2px;
            margin-right: 4%;
            /* margin-left: 4%; */
            margin-bottom: -34px;
            /* padding-left:45px; */
        }

        #middle_section1{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            width: 309px;
            height: 201px;
            padding: 30px 30px 30px 30px;
            background: #E4E4E4;
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.19);
            border-radius: 20px;;
        }

        .method_img{
            padding-left: 220px;
        }

        .card_details{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            padding-left: 10px;
            height: 70px;
        }

        .change_btn{
            display: flex;
            flex-direction: row;
            justify-items: center;
            justify-content: center;
            align-items: center;
            bottom: 0;
            width: 354px;
            height: 59px;
            background: #000000;
            border-radius: 60px;
            padding-left: 13px;
            padding-right: 13px;
            color: white;
            filter: drop-shadow(0px 4px 12px rgba(0, 0, 0, 0.15));
        }
    </style>
</head>
<body>
    <?php require APPROOT . '/views/inc/header-rider.php'; ?>
    <div id="container">
        <div id="upper_section">
            <div class="title" id="title">Wallet</div>
            <div class="sub_text">Manage your payment info here</div>
        </div> 
        
        <div id="middle_section1">            
            <div class="method_img" id="method_img"><img src="<?php echo URLROOT;?>/public/images/general/<?php if($data['card'] == 'mastercard'){echo 'mastercard';}else if($data['card'] == 'visa'){echo 'visa';}else{echo 'discover';} ?>.png" alt="card_type"></div>
            <div class="card_details">
                <!-- <div class="main_text">Card Number</div> -->
                <div class="main_text" id="card_no">card number</div>
                <div class="sub_text" id="exp_date">exp date</div>
            </div>
        </div>
        <div id="middle_section2">
            <div class="main_text">No payment method added</div>
            <div class="sub_text">Add a payment method to pay for your orders</div>
        </div>
        <div class="change_btn" id="change_btn"><a href="<?php echo URLROOT; ?>/riders/updatePayMethod">Replace Payment Method</a></div>

    </div>

    <script>
        let middle_section1 = document.getElementById("middle_section1");
        let card_no = document.getElementById("card_no");
        let exp_date = document.getElementById("exp_date");
        let change_btn = document.getElementById("change_btn");

        // if $paymentMethodCount is not 0, display the card details
        if(<?php echo $data['paymentMethodCount']; ?> != 0){
            middle_section1.style.display = "flex";
            middle_section2.style.display = "none";
            card_no.innerHTML = "**** **** **** <?php echo $data['card_no']; ?>";
            exp_date.innerHTML = "<?php echo $data['expiry']; ?>";
            // change_btn.innerHTML = "Replace Payment Method";
        }else{
            middle_section1.style.display = "none";
            middle_section2.style.display = "flex";
            change_btn.innerHTML = "Add Payment Method";
        }
    </script>
</body>
</html>