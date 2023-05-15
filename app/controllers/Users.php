<?php
    /**
     *   Application brain default focus on this USERS CLASS
     *   
     *   TASKS:
     *      i.) LOGIN
     *      ii)RESET PASSWORD
     *        
    */

    /**
     *  If Authentication is succesfull then need to send an email to the user
     *  to do that have to USE some files from the  helper/PHPMailer directory
    */
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once 'vendor/autoload.php';

    class Users extends Controller{
        /////////////////
        // CREATE VARIABLE TO CONNECT TO THE DATABASE
        ////////////////
        private $userModel;

        ///////////////
        // assigned 'User' model file
        //////////////
        public function __construct(){
            $this->userModel = $this->model('User');            
        }


        //////////////
        // USER'S LOGIN AUTHENTICATION
        /////////////
        public function login(){
            /**
             *  LOGIN AUTHENTICATION
             */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // grab data from the requested form
                $data = [
                    'email' => trim($_POST['userEmail']),
                    'password' => trim($_POST['userPassword']),

                    'email_err' => '',
                    'password_err' => '',

                ];

                ///////////////
                //  VALIDATE EMAIL AND PASSWORD
                ///////////////
                if(empty($data['email'])){
                    $data['email_err'] = ' *Please enter email';
                }else{
                    //check user/email
                    if($this->userModel->findUserByEmail($data['email'])){
                        //user found
                    }else{
                        $data['email_err'] = "*User not found";
                    }
                }

                // valid password
                if(empty($data['password'])){
                    $data['password_err'] = ' *Please enter password';
                }

                
                ///////////////
                // IF ERRORS FREE, THEN ACCORDING TO USER ROLE NEED TO CREATE SESSION AND
                // LAND IN TO HIS/HER OWNS PAGE
                //////////////
                if(empty($data['email_err']) && empty($data['password_err'])){
                    ///////////////
                    // AUTHENTICATE USER'S EMAIL AND PASSWORD
                    ///////////////
                    
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if($loggedInUser){
                        /////////////////////
                        //SEND EMAIL
                        ////////////////////
                        // $this->sendEmailToUser($data['email']);

                        
                        /////////////////
                        // CHECK USER ROLE AND CREATE A SESSION
                        /////////////////
                        $this->createUserSession($loggedInUser);
                       
                    }else{
                        $data['password_err'] = '*incorrect password';
                        $this->view('users/login',$data);
                    }
                }else{
                    $this->view('users/login', $data);
                }


            }else{
                /**
                 *     If request is not POST then this scope will be execute.
                 */
                $data = [
                    'email' => '',
                    'password' => '',

                    'email_err' => '',
                    'password_err' => '',

                ];

                // if already logged in, redirect to the user's home
                if(isset($_SESSION['user_ID'])){
                    if(ucwords($_SESSION['user_role']) == 'Owner')
                    {
                        redirect('owners/ownerLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Administrator')
                    {
                        redirect('admins/adminLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Mechanic')
                    {
                        redirect('mechanics/mechanicLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Rider')
                    {
                        redirect('riders/riderLandPage');
                    }
                }else{
                    $this->view('users/login', $data);
                }
            }
        }



        //////////////////////
        // USER'S RESET PASSWORD
        // *need to implement in future
        /////////////////////



        ///////////////////////
        //  CREATE SESSION
        ///////////////////////
        public function createUserSession($user){
            //store session data
            $_SESSION['user_ID'] = $user->userID;
            $_SESSION['user_picture'] = $user->userPicture;
            $_SESSION['user_NIC'] = $user->NIC;
            $_SESSION['user_fName'] = $user->firstName;
            $_SESSION['user_lName'] = $user->lastName;
            $_SESSION['user_pNumber'] = $user->phoneNumber;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_status'] = $user->status;
            $_SESSION['user_email'] = $user->emailAdd;
            $_SESSION['user_registered_date'] = $user->registeredDate;
            $_SESSION['stripe_customer_ID'] = $user->stripeID;

            // get current timestamp
            $lastLoggedIn = date('Y-m-d H:i:s');
            $_SESSION['user_last_logged_in'] = $lastLoggedIn;

            // update last logged in time
            $this->userModel->updateLastLoggedIn($user->userID, $lastLoggedIn);

            //store last logged in and get registered date
            $_SESSION['user_last_logged_in'] = $user->lastLoggedIn;
            $_SESSION['user_registered_date'] = $user->registeredDate;

            //redirect to the user's(owners) home
            // die("logged successfully");
            // $this->view('owners/ownerLandPage');
            if(ucwords($user->role) == 'Owner')
            {
                redirect('owners/ownerLandPage');
            }
            else if(ucwords($user->role) == 'Administrator')
            {
                redirect('admins/adminLandPage');
            }
            else if(ucwords($user->role) == 'Mechanic')
            {
                redirect('mechanics/mechanicLandPage');
            }
            else if(ucwords($user->role) == 'Rider')
            {
                redirect('riders/riderLandPage');
            }
            //redirect('owners/ownerLandPage');
        }

        ///////////////////////////////////
        // LOG OUT 
        //////////////////////////////////
        public function logout(){
            // DESTROY USER DETAILS
            unset($_SESSION['user_ID']);
            unset($_SESSION['user_picture']);
            unset($_SESSION['user_NIC']);
            unset($_SESSION['user_fName']);
            unset($_SESSION['user_lName']);
            unset($_SESSION['user_pNumber']);
            unset($_SESSION['user_role']);
            unset($_SESSION['user_status']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_registered_date']);
            unset($_SESSION['user_last_logged_in']);
            unset($_SESSION['stripe_customer_ID']);

            session_destroy();
            redirect('users/login');
        }

        
        
        

        public function signup(){
            // $this->view('users/signup');
            /**
             *  REGISTER USER
             */

            //die("signup");
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // grab data from the requested form
                
                $data = [
                    'first name' => trim($_POST['first_name']),
                    'last name' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'phone no' => trim($_POST['phone_number']),
                    'nic no' => trim($_POST['nic_number']),
        
                    'first_name_err' => '',
                    'second_name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'phone_no_err' => '',
                    'nic_no_err' => '',
                    'selected_err' => '',

                    'otp_err' => '',
                ];

                
        
                ///////////////
                //  VALIDATE NAME, EMAIL, PASSWORD AND CONFIRM PASSWORD
                ///////////////
                if(empty($data['first name'])){
                    $data['first_name_err'] = ' *Please enter first name';
                }
                if(empty($data['last name'])){
                    $data['second_name_err'] = ' *Please enter last name';
                }

                if(empty($data['email'])){
                    $data['email_err'] = ' *Please enter email address';
                }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_err'] = '*Please enter a valid email';
                }else{
                    if($this->userModel->findUserByEmail($data['email'])){
                        $data['email_err'] = "*This email is already registered";
                    }
                }
        
                if(empty($data['password'])){
                    $data['password_err'] = ' *Please enter password';
                }elseif(strlen($data['password']) < 8){
                    $data['password_err'] = ' *Password must be at least 8 characters';
                }

                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = ' *Please confirm password';
                }else{
                    if($data['password'] != $data['confirm_password']){
                        $data['confirm_password_err'] = ' *Passwords do not match';
                    }
                }
        
                if(empty($data['phone no'])){
                    $data['phone_no_err'] = ' *Please enter phone number';
                }else{
                    if($this->userModel->findPhoneNumber($data['phone no'])){  
                        $data['phone_no_err'] = "*This phone number is already registered";
                    }
                }

                if(empty($data['nic no'])){
                    $data['nic_no_err'] = '*Please enter NIC';
                }else if(!preg_match("/^[0-9]{9}[vVxX]$/", $data['nic no']) && !preg_match("/^[0-9]{12}$/", $data['nic no'])){
                    $data['nic_no_err'] = '*Please enter a valid NIC';
                }else{
                    if($this->userModel->findNicNumber($data['nic no'])){
                        $data['nic_no_err'] = "*This NIC is already registered";
                    }
                }

                if(isset($_POST['selected'])){
                    $data['selected'] = $_POST['selected'];
                }else{  
                    $data['selected_err'] = '*Please agree to the terms of service';
                }
        
                // if no errors, then proceed to register the user
                //show($data);
                
                //if(empty($data['first_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['phone_no_err']) && empty($data['nic_no_err'])){

                if(empty($data['first_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['phone_no_err']) && empty($data['nic_no_err']) && empty($data['selected_err'])){
                    // Get the current timestamp and generate MD5 hash and extract the first 6 characters
                    $timestamp = time();
                    $otp = substr(md5($timestamp), 0, 6);
                    //function to send otp to database and then check it
                    $this->userModel->otp($data['email'], $otp);
                    //function to send otp to email                    
                    $this->sendEmailToTheUser($data['email'], $otp);
                    //redirect to otp page
                    $this->view('users/enterOTP', $data);             
                }else{
                    $this->view('users/signup', $data);
                }
        
            }else{
                /**
                 *     If request is not POST then this scope will be execute.
                 */
                $data = [
                    'first name' => '',
                    'last name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'phone no' => '',
                    'nic no' => '',
        
                    'first_name_err' => '',
                    'second_name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                    'phone_no_err' => '',
                    'nic_no_err' => '',
                    'selected_err' => '',
                ];

                $this->view('users/signup', $data);
            }
        }


        //////////////////////
        // OTP GENERATOR
        /////////////////////

             //generate OTP and store in a variable
             public function generateOTP() {
                $timestamp = time(); // Get the current timestamp
                $otp = substr(md5($timestamp), 0, 6); // Generate MD5 hash and extract the first 6 characters
                
                return $otp;
            }

            //function which sends otp to $this->userModel->checkOTP($data['email'], $otp);
            public function sendOTPtoDb(){
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $data = [
                        'otp' => trim($_POST['otp']),
                        'otp_err' => '',

                        'first name' => trim($_POST['first_name']),
                        'last name' => trim($_POST['last_name']),
                        'email' => trim($_POST['email']),
                        'password' => trim($_POST['password']),
                        'phone no' => trim($_POST['phone_number']),
                        'nic no' => trim($_POST['nic_number']),
                        'stripe_customer_id' => '',
                    ];
                    if($this->userModel->checkOTP($data['email'], $data['otp'])){
                        //since otp is verified we add user to database after creating a stripe customer
                        
                        //create stripe customer
                        \Stripe\Stripe::setApiKey('sk_test_51N7cKTBadLRZpiwUvs4goHRHZ01AZ0w44ee1GRN5KETxI5ftWGtqEp38jUXq4ChDCqcIKgd2SNK4xabPqVS7pfa100tjfsQxQd');
                        $customer = \Stripe\Customer::create(array(
                            'email' => $data['email'],
                            'name' => $data['first name'] . ' ' . $data['last name'],
                            'description' => 'Customer for ' . $data['email'],
                        ));
                        //add customer id to data array
                        $data['stripe_customer_id'] = $customer->id;

                        if($this->userModel->signup($data)){
                            //redirect to login page
                            header('location: ' . URLROOT . '/users/signupSuccess');
                            return;
                        }
                        else{
                            die('Something went wrong');
                        }
                    }
                    else{
                        $data['otp_err'] = ' *OTP is incorrect';
                        $this->view('users/enterOTP', $data);
                    }
                }
            }

            public function otp(){
                redirect('riders/enterOTPfunc');

        }

        ////////////////////////////
        // SEND EMAIL TO THE USER
        ////////////////////////////
        private function sendEmailToTheUser($email , $otp){

            
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = 'true';
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($email);

            $mail->isHTML(true);


            $mail->Subject = 'Access to ' . APPLICATION_NAME;
            $mail->Body = '
            <html>
            <head>
              <title>Access to '. APPLICATION_NAME .'</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  font-size: 14px;
                }
                h1 {
                  font-size: 18px;
                  color: #444;
                  margin-bottom: 20px;
                }
                ul {
                  list-style-type: none;
                  padding: 0;
                  margin: 0;
                }
                li {
                  margin-bottom: 10px;
                }
              </style>
            </head>
            <body>
              <h1>Access to '.APPLICATION_NAME.'</h1>
              <p>Dear ' . $email . ',</p>
              <p>Greetings!</p>
              <p>We are pleased to inform you that you have been added to <b>'.APPLICATION_NAME.'</b>.</p>
              <p>Your account has been created and you can now access our platform by logging in with the following credentials:</p>
              <ul>
                <li><b>Email:</b> ' . $email . '</li>
                <li><b>OTP:</b> ' . $otp . '</li>
              </ul>
              <p>Please note that for security purposes, we strongly advise you to change your password after your first login.</p>
              <p>Thank you for choosing <b>'.APPLICATION_NAME.'</b>. If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
              <p>Best regards,<br>
              '.APPLICATION_NAME.'</p>
            </body>
            </html>
            '
            ;
            
            $mail->send();
        }

        public function signupSuccess(){
            $this->view('users/signupSuccess');
        }
    }