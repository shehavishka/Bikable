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
            height: 70%;
        }

        #container{
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #upper_section{
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: space-between;
            padding-left: 10px;
            margin-top: 112px;
        }

        #submit{
            border: none;
            margin-top: 10px;
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
    </style>
</head>
<body>
    <?php require APPROOT . '/views/inc/header-rider.php'; ?>

    <div id="container">
        <div id="upper_section">
            <div class="title" id="title">Enter Payment Details</div>
            <div class="sub_text">Bikable uses stripe for all payments</div>
        </div> 

        <form id="payment-form">
            <div id="payment-element">
                <!-- Elements will create form elements here -->
            </div>
            <button id="submit">Submit</button>
            <div id="error-message">
                <!-- Display error message to your customers here -->
            </div>
        </form>
    </div>

    <script>
        const stripe = Stripe('pk_test_51N7cKTBadLRZpiwUAuo7VnqoiP12zZUCjh2gq69TWv2u4jAUuORGu8EATMF1QwkMxjEj80IpsGFlRKnvaPrsOkMt00HkVGDmKr');

        const options = {
            mode: 'setup',
            currency: 'usd',
            // Fully customizable with appearance API.
            appearance: {/*...*/},
        };

        // Set up Stripe.js and Elements to use in checkout form
        const elements = stripe.elements(options);

        // Create and mount the Payment Element
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');
        const submitBtn = document.getElementById('submit');

        const handleError = (error) => {
        const messageContainer = document.querySelector('#error-message');
        messageContainer.textContent = error.message;
        submitBtn.disabled = false;
        }

        form.addEventListener('submit', async (event) => {
        // We don't want to let default form submission happen here,
        // which would refresh the page.
        event.preventDefault();

        // Prevent multiple form submissions
        if (submitBtn.disabled) {
            return;
        }

        // Disable form submission while loading
        submitBtn.disabled = true;

        // Trigger form validation and wallet collection
        const {error: submitError} = await elements.submit();
        if (submitError) {
            handleError(submitError);
            return;
        }

        // Create the SetupIntent and obtain clientSecret
        const res = await fetch("<?php echo URLROOT;?>/riders/create_intent", {
            method: "POST",
        });

        const {client_secret: clientSecret} = await res.json();

        // Confirm the SetupIntent using the details collected by the Payment Element
        const {error} = await stripe.confirmSetup({
            elements,
            clientSecret,
            confirmParams: {
            return_url: 'http://localhost/Bikable/riders/viewWallet',
            },
        });

        if (error) {
            // This point is only reached if there's an immediate error when
            // confirming the setup. Show the error to your customer (for example, payment details incomplete)
            handleError(error);
        } else {
            // Your customer is redirected to your `return_url`. For some payment
            // methods like iDEAL, your customer is redirected to an intermediate
            // site first to authorize the payment, then redirected to the `return_url`.
        }
        });
    </script>
</body>
</html>