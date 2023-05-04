<?php

    // this class is for owner's controller
    /**
     * 1.) Owner's landing page (ownerLandPage)
     * 2.) Owner's profile page (ownerViewsHisOwnProfile)
     * 3.) Owner edits his own profile (ownerEditsHisOwnProfile)
     * 4.1) Owner submits his new details (ownerSubmitsHisNewDetails)
     * 4.2) Owner updates his profile picture (ownerUpdatesHisProfilePicture)
     * 5.) Owner views his password change page (ownerViewsHisPasswordChange)
     * 6.) Owner submits his new password (ownerSubmitsHisNewPassword)
     * 7.) Owner adds a new user to the system button (addUserToTheSystemButton)
     * 8.) Owner adds a new user to the system form submit button (addUserToTheSystemFormSubmitButton)
     * 9.) Owner handle administrator page (administrator)
     * 10.) Owner handle mechanic page (mechanic)
     * 11.) Owner handle rider page (riders)
     * 12.) Owner handle bicycle owner page (bicycleOwner)
     * 13.) Owner handle repair log page (repairLog)
     * 14.) Owner handle docking areas page (dockingAreas)
     * 15.) Owner handle bicycle control page (bicyclesControl)
     * 16.) Owner handle rides control page (ridesControl)
     * 17.) Owner handle reports control page (reportsControl)
     * 18.) (inbuilt) Generate password length 8
     * 19.1) (inbuilt) Send email to the user
     * 19.2) (inbuilt) Send email to the user when current password is changed
     * 20.) (inbuilt) land to the error page
     * 21.) user profile view button (userProfileViewButton)
     * 22.) suspend and release user (suspendReleaseUser)
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

            // reportsID, assignedMechanic take from the database
            $reportsIDAssignedMechanicIDDetails = $this->ownerModel->ownerLandpageReportIDAssignedMechanic();
            
            // repaire log details take from the database
            $repairLogDetails = $this->ownerModel->ownerLandpageRepairLogDetails();

            // bicycles details take from the database
            $bicyclesDetails = $this->ownerModel->ownerLandpageBicyclesDetails();

            $data = [
                'docking_areas_details' => $dockingAreasDeatails,
                'reportID_assignedMechanicID_details' => $reportsIDAssignedMechanicIDDetails,
                'repair_log_details' => $repairLogDetails,
                'bicycles_details' => $bicyclesDetails
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
        // 4.1) Owner submits his new details (ownerSubmitsHisNewDetails)
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
                        $this->landToErrorPage();
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
        // 4.2) Owner updates his profile picture (ownerUpdatesHisProfilePicture)
        public function ownerUpdatesHisProfilePicture(){
            /**
             * There are,
             *      1.) Profile  Picture  upload
            */
            if(isset($_POST["submit"])){
                $img_name = $_FILES['image1']['name'];
                $img_size = $_FILES['image1']['size'];
                $tmp_name = $_FILES['image1']['tmp_name'];
                $error = $_FILES['image1']['error'];
            
                if($error === 0){
                    if($img_size > 12500000){
                        // $data['image1_err'] = "Sorry, your first image is too large.";
                        $this->landToErrorPage();
                    }
                    else{
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //Extension type of image(jpg,png)
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png"); 
            
                        if(in_array($img_ex_lc, $allowed_exs)){

                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = dirname(APPROOT).'/public/images/profile_pictures/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                            // $data['image1'] = $new_img_name;
            
                            //Insert into database
                            if($this->ownerModel->ownerUploadsHisProfilePicture($new_img_name)){
                                $_SESSION['user_picture'] = $new_img_name;
                                $this->view('owners/ownerEditsHisOwnProfile');
                            }
                            else{
                                die('Something went wrong');
                            }
                        }
                        else{
                            // $data['image1_err'] = "You can't upload files of this type";
                            $this->landToErrorPage();
                        }
                    }
                }
                else{
                    // $data['image1_err'] = "Unknown error occurred!";
                    $this->landToErrorPage();
                }
            }else{
                // $data['image1_err'] = 'Please upload atleast one image';
                $this->landToErrorPage();
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
                    $this->landToErrorPage();
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
                        $this->view('owners/ownerChangesHisPassword');
                        
                        // send email to the user
                        $userName = $_SESSION['user_fName'];
                        $userEmail = $_SESSION['user_email'];

                        $this->sendEmailToTheUserWhenPasswordChanged($userName,$userEmail);
                        echo "<script>
                                    Swal.fire(
                                        'Password changed successfully',
                                        'success'
                                    )
                            </script>";
                    }else{
                        // die('something went wrong');
                        $this->landToErrorPage();
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
                        $this->landToErrorPage();
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
        // 13.) Owner handle repair log page (repairLog)
        public function repairLog(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
            */
            $this->landToErrorPage();
            // $this->view('owners/repairLog');
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

            $dockingAreaDetails = $this->ownerModel->getDockingAreasDetails();

            $data = [
                'docking_areas_details' => $dockingAreaDetails
            ];

            $this->view('owners/dockingareas', $data);
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

            $bicyclesDetails = $this->ownerModel->getBicyclesDetails();

            $data = [
                'bicycles_details' => $bicyclesDetails
            ];

            $this->view('owners/bicycles', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 16.) Owner handle rides control page (ridesControl)
        public function ridesControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */

            // load rides data
            $ridesDetails = $this->ownerModel->getRidesDetails();

            $data = [
                'rides_details' => $ridesDetails
            ];

            //this is not load data from the database
            $this->view('owners/rides', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 17.) Owner handle reports control page (reportsControl)
        public function reportsControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */

            $reportDetails = $this->ownerModel->getReportDetails();
            $data = [
                'reports_details' => $reportDetails
            ];

            $this->view('owners/reports', $data);
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
        // 19.1) (inbuilt) Send email to the user
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

        //////////////////////////////////////////////////////////////////////////////////////////////////
        // 19.2) (inbuilt) Send email to the user when current password is changed
        private function sendEmailToTheUserWhenPasswordChanged($userName, $userEmail){

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

            $mail->Subject = 'Password Changed for ' . APPLICATION_NAME;
            $mail->Body = '            
                    <html>
                    <head>
                    <title>Password Changed for '. APPLICATION_NAME .'</title>
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
                    <h1>Password Changed for '.APPLICATION_NAME.'</h1>
                    <br>
                    <p>Dear '. $userName .',</p>
                    <p>We wanted to let you know that your password for '.APPLICATION_NAME.' has been changed.<br> If you did not request this change, please contact our support team immediately at <a href="mailto:support@bikable.com">'.APPEMAIL.'</a>.</p>
                    <p>If you did change your password, you can ignore this message.</p>
                    <br>
                    <p>Thank you for using BIKABLE.</p>
                    <p>Best regards,<br>The '.APPLICATION_NAME.' Team</p>
                    </body>
                    </html>'
                ;
            
            $mail->send();
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 20.) (inbuilt) land to the error page
        public function landToErrorPage(){
            //load the error page only view
            $this->view('users/error');
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 21.) user profile view button (userProfileViewButton)
        public function userProfileViewButton(){
            // get the user id from the form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'userDetailObject' => ''
                ];
                //get the user details from the database
                $data['userDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findUserByUserID($data['userID']);
                
                //load the user profile view page
                $this->view('owners/ownerViewsUserProfile', $data);
            }else{
                // die("button didn't work correctly.");
                $this->landToErrorPage();
            }            
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 22.) suspend and release user (suspendReleaseUser)
        public function suspendReleaseUser(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userIdentity' => intval(trim($_POST['userIdentity'])),
                    'userStatus' => intval(trim($_POST['userStatus']))
                ];
                
                //suspend the user and release the user
                if($data['userStatus'] == 1){
                    $isUserSuspend = $this->ownerModel->suspendUserByUserID($data['userIdentity']);
                    if($isUserSuspend){
                        //land to the administrator page
                        $this->administrator();
                    }else{
                        // die("some thing went wrong at the suspend process");
                        $this->landToErrorPage();
                    }
                }elseif ($data['userStatus'] == 0) {
                    $isUserRelease = $this->ownerModel->activateUserByUserID($data['userIdentity']);
                    if($isUserRelease){
                        //land to the administrator page
                        $this->administrator();
                    }else{
                        // die("some thing went wrong at the suspend process");
                        $this->landToErrorPage();
                    }
                }else{
                    // die("some thing went wrong at the suspend process");
                    $this->landToErrorPage();
                }
            }else{
                // die("some thing went wrong at the suspend process");
                $this->landToErrorPage();
            }   
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 23.) Statistics
        public function statisticsPageView(){
            /**
             * There are,
             *      1.) Load the data
             *     2.) View the data 
            */

            //get total riders from the database
            $totalRiders = $this->ownerModel->getTotalRiders();
            $riderCount = $totalRiders->{'COUNT(*)'};

            //get total bikes from the database
            $totalBikes = $this->ownerModel->getTotalBicycles();
            $bikeCount = $totalBikes->{'COUNT(*)'};

            //get total docking areas from the database
            $totalDockingAreas = $this->ownerModel->getTotalDockingAreas();
            $dockingAreaCount = $totalDockingAreas->{'COUNT(*)'};

            //get active reports from the database
            $activeReports = $this->ownerModel->getActiveReports();
            $activeReportCount = $activeReports->{'COUNT(*)'};

            $data = [
                'totalRiders' => $riderCount,
                'totalBikes' => $bikeCount,
                'totalDockingAreas' => $dockingAreaCount,
                'activeReports' => $activeReportCount
            ];
            
            $this->view('owners/statistics', $data);
        }
    }