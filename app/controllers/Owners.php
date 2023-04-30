<?php

    // this class is for owner's controller
    /**
     * 1.) Owner's landing page (ownerLandPage)
     * 2.) Owner's profile page (ownerViewsHisOwnProfile)
     * 3.) Owner edits his own profile (ownerEditsHisOwnProfile)
     * 4.) Owner submits his new details (ownerSubmitsHisNewDetails)
     * 5.) Owner views his password change page (ownerViewsHisPasswordChange)
     * 6.) Owner submits his new password (ownerSubmitsHisNewPassword)
     * 7.) Owner adds a new user to the system button (addUserToTheSystemButton)
     * 8.) Owner adds a new user to the system form submit button (addUserToTheSystemFormSubmitButton)
     * 9.) Owner handle administrator page (administrator)
     * 10.) Owner handle mechanic page (mechanic)
     * 11.) Owner handle rider page (riders)
     * 12.) Owner handle bicycle owner page (bicycleOwner)
     * 13.) Owner handle add new repair log page (addNewRepairLog)
     * 14.) Owner handle docking areas page (dockingAreas)
     * 15.) Owner handle bicycle control page (bicyclesControl)
     * 16.) Owner handle rides control page (ridesControl)
     * 17.) Owner handle reports control page (reportsControl)
     * 18.) (inbuilt) Generate password length 8
     * 19.) (inbuilt) Send email to the user
     * 20.) (inbuilt) land to the error page
     */

    // dependencies for phpmailer
    use PHPMailer\PHPMailer\PHPMailer;

    class Owners extends Controller{

        // Owner connects to the database using this variable.
        private $ownerModel;

        public function __construct(){

            // ownerModel variable connect to the Owner model
            $this->ownerModel = $this->model('Owner');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 1.) Owner's landing page (ownerLandPage)
        public function ownerLandPage(){
            /**
             *    There are,
             *          1.) Three tables
             *              a.) Reports table
             *              b.) Reports log table
             *              c.) Bicycle details table
             *          2.) 4 buttons -> done
             *          3.) 1 map -> done
             *          4.) 2 graphs
             *        
            */

            // docking areas details for the map take from the database
            $dockingAreasDeatails = $this->ownerModel->ownerLandPageMapDetails();
            
            
            $data = [
                'docking_areas_details' => $dockingAreasDeatails
            ];

            // load the data form UI and send all data to the UI
            $this->view('owners/ownerLandPage', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 2.) Owner's profile page (ownerViewsHisOwnProfile)
        public function ownerViewsHisOwnProfile(){
           /**
            * There are,
            *      1.) Profile Picture -> done
            *      2.) User ID
            *      3.) Last Logged in
            *      4.) Registered Date
            *      5.) Session Details need to be added -> done
            */

            $this->view('owners/ownerViewsHisOwnProfile');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 3.) Owner edits his own profile (ownerEditsHisOwnProfile)
        public function ownerEditsHisOwnProfile(){
            /**
             * There are,
             *      1.) Profile Picture -> done
             *      2.) User ID
             *      3.) Last Logged in  
             *      4.) Registered Date
             *      5.) There is a form to edit name, email, phone number, NIC number -> done
            */

            $this->view('owners/ownerEditsHisOwnProfile');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 4.) Owner submits his new details (ownerSubmitsHisNewDetails)
        public function ownerSubmitsHisNewDetails(){
            /**
             * This function is for update owner's details
             * need to validate submitted data 
            */

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'nic' => trim($_POST['nic_number']),
                    // 'status' => trim($_POST['status']),
                    // 'pNumber' => trim($_POST['contact_number']),
                    // 'userRole' => strtolower(trim($_POST['user_role'])),
                    // 'userPassword' => '', // this generate after confirmed entered details are ready.

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'status_err' => '',
                    // 'pNumber_err' => '',
                    // 'userRole_err' => ''
                ];

                //validate first name weather it is empty or not
                if(empty($data['fName'])){
                    $data['fName'] = $_SESSION['user_fName'];
                } 

                //validate last name weather it is empty or not
                if(empty($data['lName'])){
                    $data['lName'] = $_SESSION['user_lName'];
                }

                //validate email weather it is empty or not
                if(empty($data['email'])){
                    $data['email'] = $_SESSION['user_email'];
                }else{
                    //check weather email is availble in database
                    // true means that email is already taken.
                    if($this->ownerModel->findUserByEmail($data['email'])){
                        $data['email_err'] = "*email is already taken";
                    }else{
                        //update email
                        //pass
                    }
                }

                //validate nic weather it is empty or not
                if(empty($data['nic'])){
                    $data['nic'] = $_SESSION['user_NIC'];
                }else{
                    //check weather nic is availble in database
                    // true means that nic is already taken.
                    if($this->ownerModel->findNicNumber($data['nic'])){
                        $data['nic_err'] = "*NIC is already taken";
                    }else{
                        //update nic
                        //pass
                    }
                }

                //validate phone number weather it is empty or not
                // if(empty($data['pNumber'])){
                //     $data['pNumber_err'] = '*enter phone Number';
                // }else{
                //     //check weather phone number is availble in database
                //     // true means that phone number is already taken.
                //     if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                //         
                //         $data['pNumber_err'] = "*Phone Number is already taken";
                //     }else{
                //         //pass
                //     }
                //}

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) &&  empty($data['nic_err'])){
                    //if all data are valid then update user details
                    if($this->ownerModel->ownerUpdatesHisData($data)){
                        //update session variables
                        $_SESSION['user_fName'] = $data['fName'];
                        $_SESSION['user_lName'] = $data['lName'];
                        $_SESSION['user_email'] = $data['email'];                       
                        $_SESSION['user_NIC'] = $data['nic'];
                        
                        //redirect to the profile page
                        $this->view('owners/ownerViewsHisOwnProfile');
                    }else{
                        // die('something went wrong');
                        //redirect to the error page
                        $this->view('users/error');
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/ownerEditsHisOwnProfile', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'email' => '',
                    'nic' => '',
                    // 'pNumber' => '',
                    // 'password' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'pNumber_err' => '',
                    // 'password_err' => '',
                ];

                //load the view
                $this->view('owners/ownerEditsHisOwnProfile', $data);
            }

        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 5.) Owner views his password change page (ownerViewsHisPasswordChange)
        public function ownerViewsHisPasswordChange(){
            /**
             * There are,
             *      1.) Load the form that's it.
            */
            $this->view('owners/ownerChangesHisPassword');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 6.) Owner submits his new password (ownerSubmitsHisNewPassword)
        public function ownerSubmitsHisNewPassword(){
            // load the form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'currentPassword' => trim($_POST['current-password']),
                    'newPassword' => trim($_POST['new-password']),
                    'confirmPassword' => trim($_POST['confirm-password']),

                    'currentPassword_err' => '',
                    'confirmPassword_err' => '',

                ];

                // store the user id in a variable
                $userID = $_SESSION['user_ID'];

                //find user details by user id
                $userDetails = $this->ownerModel->findUserByUserID($userID);

                // check weather current password is correct or not
                if($userDetails){

                    $userHashedValue = $userDetails->password;
                    if(password_verify(strval($data['currentPassword']),strval($userHashedValue))){
                        //verified
                    }else{
                        // if not verified
                        $data['currentPassword_err'] = "*invalid password";
                    }
                }else{
                    //user not found
                    // die("Something went wrong!!!");
                    $this->view('users/error');
                }

                // check weather new password and confirm password are equal or not
                if(strval($data["newPassword"]) == strval($data["confirmPassword"])){
                    //pass
                }else{
                    $data["confirmPassword_err"] = "*password doesn't match";
                }

                // check weather there are no errors
                if(empty($data['currentPassword_err']) && empty($data['confirmPassword_err'])){
                    
                    //allow to change password
                    if($this->ownerModel->ownerChangesHisPassword($data)){
                        $this->view('owners/ownerViewsHisOwnProfile');
                    }else{
                        // die('something went wrong');
                        $this->view('users/error');
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/ownerChangesHisPassword', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'email' => '',
                    'nic' => '',
                    // 'pNumber' => '',
                    // 'password' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'pNumber_err' => '',
                    // 'password_err' => '',

                ];
                //load the view
                $this->view('owners/ownerEditsHisOwnProfile', $data);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 7.) Owner adds a new user to the system button (addUserToTheSystemButton)
        public function addUserToTheSystemButton(){
            /**
             * There is,
             *      1.) Load the form that's it.
            */

            $this->view('owners/addUser');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 8.) Owner adds a new user to the system form submit button (addUserToTheSystemFormSubmitButton)
        public function addUserToTheSystemFormSubmitButton(){
            /**
             * There are,
             *      1.) Validate the form data -> done
             *      2.) Generate a password -> done
             *      3.) If there are no errors then add the user to the system -> done
             *      4.) Send an email to the user with the password -> done
            */

            // load the form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'status' => trim($_POST['status']),
                    'nic' => trim($_POST['nic_number']),
                    'pNumber' => trim($_POST['contact_number']),
                    'userRole' => strtolower(trim($_POST['user_role'])),

                    'userPassword' => '', // this generate after confirmed entered details are ready.

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'status_err' => '',
                    'nic_err' => '',
                    'pNumber_err' => '',
                    'userRole_err' => ''
                ];

                //validate first name
                if(empty($data['fName'])){
                    $data['fName_err'] = '*enter first name';
                } 

                //validate last name
                if(empty($data['lName'])){
                    $data['lName_err'] = '*enter last name';
                }

                //validate email
                if(empty($data['email'])){
                    $data['email_err'] = '*enter email Number';
                }else{
                    //check weather email is availble in database
                    // true means that email is already taken.
                    if($this->ownerModel->findUserByEmail($data['email'])){
                        $data['email_err'] = "*email is already taken";
                    }else{
                        //pass
                    }
                }

                //validate NIC
                if(empty($data['nic'])){
                    $data['nic_err'] = '*enter NIC number';
                }else{
                    //check weather nic is availble in database
                    // true means that email is already taken.
                    if($this->ownerModel->findNicNumber($data['nic'])){
                        $data['nic_err'] = "*NIC is already taken";
                    }else{
                        //pass
                    }
                }

                //validate phone number
                if(empty($data['pNumber'])){
                    $data['pNumber_err'] = '*enter phone Number';
                }else{
                    //check weather phone number is availble in database.
                    // true means that phone number is already taken.
                    if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                        $data['pNumber_err'] = "*Phone Number is already taken";
                    }else{
                        //pass
                    }
                }

                // if there is no error then add the user to the system
                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) && empty($data['status_err'])  && empty($data['nic_err']) && empty($data['pNumber_err']) && empty($data['userRole_err'])){

                    // generate password -> calls generatePassword() function
                    $data['userPassword'] = $this->generatePassword();
                    // $data['userPassword'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    
                    // send email to the user -> calls sendEmailToTheUser() function                    
                    $this->sendEmailToTheUser($data['fName'] ,$data['email'], $data['userPassword']);

                    // add user to the system
                    if($this->ownerModel->addUserIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->view('owners/addUser');
                    }else{
                        // die('something went wrong');
                        $this->view('users/error');
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/addUser', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'pNumber' => '',
                    'email' => '',
                    'password' => '',
                    'nic' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'pNumber_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'nic_err' => '',

                ];
                $this->view('owners/addUser', $data);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 9.) Owner handle administrator page (administrator)
        public function administrator(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */
            
            // load administrator's data
            $administratorsDetails = $this->ownerModel->getAdminDetails();
            $data = [
                'admin_details' => $administratorsDetails
            ];

            //view details
            $this->view('owners/administrator',$data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 10.) Owner handle mechanic page (mechanic)
        public function mechanic(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */

            // load mechanic's data
            $mechanicDetails = $this->ownerModel->getMechanicDetails();
            $data = [
                'mechanic_details' => $mechanicDetails
            ];

            //view details
            $this->view('owners/mechanic', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 11.) Owner handle rider page (riders)
        public function riders(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */

            // load rider's data
            $ridersDetails = $this->ownerModel->getRiderDetails();
            $data = [
                'rider_details' => $ridersDetails
            ];

            //view details
            $this->view('owners/riders', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 12.) Owner handle bicycle owner page (bicycleOwner)
        public function bicycleOwner(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here
            $bikeOwnerDetails = $this->ownerModel->getbikeOwnerDetails();
            $data = [
                'bikeOwner_details' => $bikeOwnerDetails
            ];

            //view details
            $this->view('owners/bicycleOwner', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 13.) Owner handle add new repair log page (addNewRepairLog)
        public function addNewRepairLog(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
            */
            $this->view('owners/addNewRepairLog');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 14.) Owner handle docking areas page (dockingAreas)
        public function dockingAreas(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
             *   
            */
            $this->view('owners/dockingareas');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 15.) Owner handle bicycle control page (bicyclesControl)
        public function bicyclesControl(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
             *   
            */
            $this->view('owners/bicycles');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 16.) Owner handle rides control page (ridesControl)
        public function ridesControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */

             //this is not load data from the database
            $this->view('owners/rides');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 17.) Owner handle reports control page (reportsControl)
        public function reportsControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */
            $this->view('owners/reports');
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 18.) (inbuilt) Generate password length 8
        private function generatePassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////
        // 19.) (inbuilt) Send email to the user
        private function sendEmailToTheUser($userName, $userEmail , $userPassword){

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = 'true';
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($userEmail);

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
              <p>Dear ' . $userName . ',</p>
              <p>Greetings!</p>
              <p>We are pleased to inform you that you have been added to <b>'.APPLICATION_NAME.'</b>.</p>
              <p>Your account has been created and you can now access our platform by logging in with the following credentials:</p>
              <ul>
                <li><b>Email:</b> ' . $userEmail . '</li>
                <li><b>Password:</b> ' . $userPassword . '</li>
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

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 20.) (inbuilt) land to the error page
        public function landToErrorPage(){
            //load the error page only view
            $this->view('users/error');
        }


        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////// UPDATE BUTTON (SUSPEND) ///////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        public function viewUserPersonallyPenButton(){
            /**
             *  Task one load the user detail button
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'userDetailObject' => ''
                ];
                $data['userDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findUserByUserID($data['userID']);
                $this->view('owners/ownerViewsUserProfile', $data);
            }else{
                // die("button didn't work correctly.");
                $this->view('users/error');
            }            
        }

        //suspend process of the user by owner
        public function suspendUser(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userIdentity' => intval(trim($_POST['userIdentity']))
                ];
                
                $isUserSuspend = $this->ownerModel->suspendUserByUserID($data['userIdentity']);
                if($isUserSuspend){
                    $this->view('owners/ownerLandPage');
                }
            }else{
                // die("some thing went wrong at the suspend process");
                $this->view('users/error');
            }   
        }
    }