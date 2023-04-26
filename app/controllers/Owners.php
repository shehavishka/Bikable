<?php

    use PHPMailer\PHPMailer\PHPMailer;

    class Owners extends Controller{
        // owner connect to the database
        private $ownerModel;

        public function __construct(){
            // connect to the database
            $this->ownerModel = $this->model('Owner');
        }

        public function ownerLandPage(){
            /**
             *  Two tasks
             *      1.) Load the data
             *      2.) View the data 
            */

            // load owner's landpage
            //code will implement here
            // 1. Load Map details
            $dockingAreasDeatails = $this->ownerModel->ownerLandPageMapDetails();
            $data = [
                'docking_areas_details' => $dockingAreasDeatails
            ];

            //view details
            $this->view('owners/ownerLandPage', $data);
        }

        /////////////////////////////////////////////////
        // OWNER LANDPAGE ADMIN/ MECHANIC/ BICYCLE/ OWNER RIDERS, BUTTONS IMPLEMENT
        /////////////////////////////////////////////////
        // test comment

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////// ADD USER INTO THE SYSTEM /////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function addUserToTheSystemButton(){
            /**
             *  Two tasks 1
             *      1.) Load the form      
            */

            // load the data form UI
            $this->view('owners/addUser');
        }

        // after addUser form filled if they are valid then insert data into the system
        public function addUserToTheSystemFormSubmitButton(){
            /**
             *  Task
             *      This function task is validate data from the addUser form and,
             *          generate the password and send it the user 
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
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

                //validate submitted data
                //validate first_name
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
                    if($this->ownerModel->findUserByEmail($data['email'])){
                        // true means that email is already taken.
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
                    if($this->ownerModel->findNicNumber($data['nic'])){
                        // true means that email is already taken.
                        $data['nic_err'] = "*NIC is already taken";
                    }else{
                        //pass
                    }
                }

                //validate phone number
                if(empty($data['pNumber'])){
                    $data['pNumber_err'] = '*enter phone Number';
                }else{
                    //check weather phone number is availble in database
                    if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                        // true means that email is already taken.
                        $data['pNumber_err'] = "*Phone Number is already taken";
                    }else{
                        //pass
                    }
                }

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) && empty($data['status_err'])  && empty($data['nic_err']) && empty($data['pNumber_err']) && empty($data['userRole_err'])){
                    //every things up to ready 

                    // hash password
                    // $data['userPassword'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    $data['userPassword'] = $this->generatePassword();
                    
                    //After authentication is done send new Password to the user to his/her email.
                    $this->sendEmailToTheUser($data['fName'] ,$data['email'], $data['userPassword']);

                    // register user
                    if($this->ownerModel->addUserIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->view('owners/addUser');
                    }else{
                        die('something went wrong');
                    }
                }else{
                    $this->view('owners/addUser', $data);
                }

            }else{
                //init data
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


        // owner controll administrator
        public function administrator(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's administrator control
            $administratorsDetails = $this->ownerModel->getAdminDetails();
            $data = [
                'admin_details' => $administratorsDetails
            ];

            //view details
            $this->view('owners/administrator',$data);
        }

        // owner controll Mechanic data view
        public function mechanic(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here
            $mechanicDetails = $this->ownerModel->getMechanicDetails();
            $data = [
                'mechanic_details' => $mechanicDetails
            ];

            //view details
            $this->view('owners/mechanic', $data);
        }

        // owner controll Mechanic data view
        public function riders(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here
            $mechanicDetails = $this->ownerModel->getRiderDetails();
            $data = [
                'rider_details' => $mechanicDetails
            ];

            //view details
            $this->view('owners/riders', $data);
        }

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

        // owner controll repair log
        public function addNewRepairLog(){
            /**
             *  Tasks 
             *        1.) add repair log to the system
             * 
            */

            // this is not load data from the database
            $this->view('owners/addNewRepairLog');
        }

        // owner controll docking areas
        public function dockingAreas(){
            /**
             * Task
             *      1.) add docking area to the system
             */

            //this is not load data from the database
            $this->view('owners/dockingareas');
        }

        // owner controll bicycle details
        public function bicyclesControl(){
            /**
             * Task 
             *      1.) handle bicycles in the system.
             */

            //this is not load data from the database
            $this->view('owners/bicycles');
        }

        // owner views the the rides and controll
        public function ridesControl(){
            /**
             *  Task
             *      1.) handle rides in the system
             */

             //this is not load data from the database
            $this->view('owners/rides');
        }

        // owner vies the reports and controll
        public function reportsControl(){
            /**
             * Task 
             *      1.) handle reports in the system
             */

            //this is not load data from the data
            $this->view('owners/reports');
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                die("button didn't work correctly.");
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
                die("some thing went wrong at the suspend process");
            }   
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////// USER VIEWS HIS OWN PROFILE ////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function ownerViewHisOwnProfile(){
            /**
             * show user data             * 
            */

            $this->view('owners/ownerViewsHisOwnProfile');
        }

        // //////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////// OWNER VIEWS HIS OWN PROFILE /////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////


        public function ownerEditsHisOwnProfile(){
            /**
             * view the data
             * no need to load because of already showing user data
             */

            $this->view('owners/ownerEditsHisOwnProfile');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////// OWNER EDITS HIS OWN PROFILE /////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        public function ownerSubmistHisNewDetails(){
            /**
             *  This function owner update his details and need to check user input data
             * 
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    // 'status' => trim($_POST['status']),
                    'nic' => trim($_POST['nic_number']),
                    // 'pNumber' => trim($_POST['contact_number']),
                    // 'userRole' => strtolower(trim($_POST['user_role'])),

                    // 'userPassword' => '', // this generate after confirmed entered details are ready.

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    // 'status_err' => '',
                    'nic_err' => '',
                    // 'pNumber_err' => '',
                    // 'userRole_err' => ''
                ];

                //validate submitted data
                //validate first_name
                if(empty($data['fName'])){
                    $data['fName'] = $_SESSION['user_fName'];
                } 

                //validate last name
                if(empty($data['lName'])){
                    $data['lName'] = $_SESSION['user_lName'];
                }

                //validate email
                if(empty($data['email'])){
                    $data['email'] = $_SESSION['user_email'];
                }else{
                    //check weather email is availble in database
                    if($this->ownerModel->findUserByEmail($data['email'])){
                        // true means that email is already taken.
                        $data['email_err'] = "*email is already taken";
                    }else{
                        //pass
                    }
                }


                //validate NIC
                if(empty($data['nic'])){
                    $data['nic'] = $_SESSION['user_NIC'];
                }else{
                    //check weather nic is availble in database
                    if($this->ownerModel->findNicNumber($data['nic'])){
                        // true means that email is already taken.
                        $data['nic_err'] = "*NIC is already taken";
                    }else{
                        //pass
                    }
                }

                //validate phone number
                // if(empty($data['pNumber'])){
                //     $data['pNumber_err'] = '*enter phone Number';
                // }else{
                //     //check weather phone number is availble in database
                //     if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                //         // true means that email is already taken.
                //         $data['pNumber_err'] = "*Phone Number is already taken";
                //     }else{
                //         //pass
                //     }
                // }

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) &&  empty($data['nic_err'])){
                    // register user
                    if($this->ownerModel->ownerUpdatesHisData($data)){
                        // next implementation should be land into the right position according to the role
                        $this->view('owners/ownerViewsHisOwnProfile');
                    }else{
                        die('something went wrong');
                    }
                }else{
                    $this->view('owners/ownerEditsHisOwnProfile', $data);
                }

            }else{
                //init data
                $data = [
                    'fName' => '',
                    'lName' => '',
                    // 'pNumber' => '',
                    'email' => '',
                    // 'password' => '',
                    'nic' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    // 'pNumber_err' => '',
                    'email_err' => '',
                    // 'password_err' => '',
                    'nic_err' => '',

                ];
                $this->view('owners/ownerEditsHisOwnProfile', $data);
            }

        }

    }