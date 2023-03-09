<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    class Admins extends Controller{
        // admin connect to the database
        private $adminModel;

        public function __construct(){
            // connect to the database
            $this->adminModel = $this->model('Admin');
        }

        public function adminLandPage(){
            /**
             *  Two tasks
             *      1.) Load the data
             *      2.) View the data 
            */

            // load admin's mechanic control
            //code will implement here
            $reportDetails = $this->adminModel->getDashboardReports();
            $repairlogDetails = $this->adminModel->getDashboardRepairLog();
            $bicyclesDetails = $this->adminModel->getDashboardBicycles();
            $ridesDetails = $this->adminModel->getDashboardRides();
            $data = [
                'dashboard_reports' => $reportDetails,
                'dashboard_repairlog' => $repairlogDetails,
                'dashboard_bicycles' => $bicyclesDetails,
                'dashboard_rides' => $ridesDetails
            ];

            //view details
            $this->view('admins/adminLandPage');
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
                'userRole_err' => '',

            ];
            // load the data form UI
            $this->view('admins/addUser', $data);
        }

        // after addbikeOwner form filled if they are valid then insert data into the system
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
                    if($this->adminModel->findUserByEmail($data['email'])){
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
                    if($this->adminModel->findNicNumber($data['nic'])){
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
                    if($this->adminModel->findPhoneNumber($data['pNumber'])){
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
                    //$this->sendEmailToTheUser($data['fName'] ,$data['email'], $data['userPassword']);

                    // register user
                    if($this->adminModel->addUserIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->mechanic();
                    }else{
                        die('something went wrong');
                    }
                }
                else{
                    $this->view('admins/addUser', $data);
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
                $this->view('admins/addUser', $data);
            }
        }

        
        // admin controll administrator
        public function administrator(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
             *  */ 

            // load admin's administrator control
            //code will implement here

            //view details
            $this->view('admins/administrator');
        }

        // admin controll Mechanic data view
        public function mechanic(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
            // load admin's mechanic control
            //code will implement here
            $mechanicDetails = $this->adminModel->getMechanicDetails();
            $data = [
                'mechanic_details' => $mechanicDetails
            ];
        
            //view details
            $this->view('admins/mechanic', $data);
        }

        // admin controll Mechanic data view
        public function riders(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
            // load admin's rider control
            //code will implement here
            $riderDetails = $this->adminModel->getRiderDetails();
            $data = [
                'rider_details' => $riderDetails
            ];
        
            //view details
            $this->view('admins/riders', $data);
        }
        
        ///////////////BIKE OWNER/////////////////////
        public function addBikeOwnerToTheSystemButton(){
            /**
             *  Two tasks 1
             *      1.) Load the form      
            */
            $data = [
                'fName' => '',
                'lName' => '',
                'pNumber' => '',
                'email' => '',
                'nic' => '',

                'fName_err' => '',
                'lName_err' => '',
                'pNumber_err' => '',
                'email_err' => '',
                'nic_err' => '',

            ];
            // load the data form UI
            $this->view('admins/addBicycleOwner', $data);
        }

        // after addbikeOwner form filled if they are valid then insert data into the system
        public function addBikeOwnerToTheSystemFormSubmitButton(){
            /**
             *  Task
             *      This function task is validate data from the addBikeOwner form and,
             *         1.) if data is valid then send data to insert into the system
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'nic' => trim($_POST['nic_number']),
                    'pNumber' => trim($_POST['contact_number']),

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    'pNumber_err' => '',
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
                    if($this->adminModel->findBOByEmail($data['email'])){
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
                    if($this->adminModel->findBONicNumber($data['nic'])){
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
                    if($this->adminModel->findBOPhoneNumber($data['pNumber'])){
                        // true means that email is already taken.
                        $data['pNumber_err'] = "*Phone Number is already taken";
                    }else{
                        //pass
                    }
                }

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) && empty($data['status_err'])  && empty($data['nic_err']) && empty($data['pNumber_err']) && empty($data['userRole_err'])){
                    //every things up to ready 

                    // add bike owner
                    if($this->adminModel->addBikeOwnerIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->bicycleOwner();
                    }else{
                        die('something went wrong');
                    }
                }
                else{
                    $this->view('admins/addBicycleOwner', $data);
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
                $this->view('admins/addBicycleOwner', $data);
            }
        }

        public function bicycleOwner(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
            // load admin's bikeOwner control
            //code will implement here
            $bikeOwnerDetails = $this->adminModel->getbikeOwnerDetails();
            $data = [
                'bikeOwner_details' => $bikeOwnerDetails
            ];

            //view details
            $this->view('admins/bicycleOwner', $data);
        }

        // admin controll repair log
        //put the update and delete functions here

        ///////////////DOCKING AREA/////////////////////
        public function addDAToTheSystemButton(){
            /**
             *  Two tasks 1
             *      1.) Load the form      
            */
            $data = [
                'areaName' => '',
                'locationLat' => '',
                'locationLong' => '',
                'locationRadius' => '',
                'traditionalAdd' => '',
                'status' => '',
                'currentNoOfBikes' => '',

                'areaName_err' => '',
                'locationLat_err' => '',
                'locationLong_err' => '',
                'locationRadius_err' => '',
                'traditionalAdd_err' => '',
                'status_err' => '',
                'currentNoOfBikes_err' => '',

            ];
            // load the data form UI
            $this->view('admins/addDockingArea', $data);
        }

        // after addDA form filled if they are valid then insert data into the system
        public function addDAToTheSystemFormSubmitButton(){
            /**
             *  Task
             *      This function task is validate data from the addBikeOwner form and,
             *         1.) if data is valid then send data to insert into the system
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'areaName' => trim($_POST['areaName']),
                    'locationLat' => trim($_POST['locationLat']),
                    'locationLong' => trim($_POST['locationLong']),
                    'locationRadius' => trim($_POST['locationRadius']),
                    'traditionalAdd' => trim($_POST['traditionalAdd']),
                    'status' => trim($_POST['status']),
                    'currentNoOfBikes' => trim($_POST['currentNoOfBikes']),

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',
                ];

                //validate submitted data
                if(empty($data['areaName'])){
                    $data['areaName_err'] = '*enter area name';
                }

                if(empty($data['locationLat'])){
                    $data['locationLat_err'] = '*enter location latitude';
                }

                if(empty($data['locationLong'])){
                    $data['locationLong_err'] = '*enter location longitude';
                }

                if(empty($data['locationRadius'])){
                    $data['locationRadius_err'] = '*enter location radius';
                }

                if(empty($data['traditionalAdd'])){
                    $data['traditionalAdd_err'] = '*enter traditional address';
                }

                if(empty($data['status'])){
                    $data['status_err'] = '*enter status';
                }

                if(empty($data['currentNoOfBikes'])){
                    $data['currentNoOfBikes'] = 0;
                }

                //make sure there are no errors
                if(empty($data['areaName_err']) && empty($data['locationLat_err']) && empty($data['locationLong_err']) && empty($data['locationRadius_err']) && empty($data['traditionalAdd_err']) && empty($data['status_err']) && empty($data['currentNoOfBikes_err'])){
                    //every things up to ready 

                    // add docking area
                    if($this->adminModel->addDAIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->dockingAreas();
                    }else{
                        die('something went wrong');
                    }
                }
                else{
                    // print_r('something went wrong');
                    // print_r($data['status_err']);
                    $this->view('admins/addDockingArea', $data);
                }
            }else{
                //init data
                $data = [
                    'areaName' => '',
                    'locationLat' => '',
                    'locationLong' => '',
                    'locationRadius' => '',
                    'traditionalAdd' => '',
                    'status' => '',
                    'currentNoOfBikes' => '',

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',

                ];
                $this->view('admins/addDockingArea', $data);
            }
        }

        // admin controll docking areas
        public function dockingAreas(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
            // load admin's DA control
            //code will implement here
            $DADetails = $this->adminModel->getDADetails();
            $data = [
                'DA_details' => $DADetails
            ];
        
            //view details
            $this->view('admins/dockingareas', $data);
        }


        ///////////////BICYCLE/////////////////////
        public function addBicycleToTheSystemButton(){
            /**
             *  Two tasks 1
             *      1.) Load the form      
            */
            $data = [
                'bikeOwnerID' => '',
                'frameSize' => '',
                'dateAcquired' => '',
                'datePutInUse' => '',
                'status' => '',
                'currentDA' => '',
            
                'bikeOwnerID_err' => '',
                'frameSize_err' => '',
                'dateAcquired_err' => '',
                'datePutInUse_err' => '',
                'status_err' => '',
                'currentDA_err' => '',

            ];
            // load the data form UI
            $this->view('admins/addBicycle', $data);
        }

        // after addbike form filled if they are valid then insert data into the system
        public function addBicycleToTheSystemFormSubmitButton(){
            /**
             *  Task
             *      This function task is validate data from the addbike form and,
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'bikeOwnerID' => trim($_POST['bikeOwnerID']),
                    'frameSize' => trim($_POST['frameSize']),
                    'dateAcquired' => trim($_POST['dateAcquired']),
                    'datePutInUse' => trim($_POST['datePutInUse']),
                    'status' => trim($_POST['status']),
                    'currentDA' => trim($_POST['currentDA']),

                    'bikeOwnerID_err' => '',
                    'frameSize_err' => '',
                    'dateAcquired_err' => '',
                    'datePutInUse_err' => '',
                    'status_err' => '',
                    'currentDA_err' => '',
                ];

                //validate submitted data
                //validate bicycle owner ID
                if(empty($data['bikeOwnerID'])){
                    $data['bikeOwnerID_err'] = '*enter bicycle owner ID';
                } 

                //validate frame size
                if(empty($data['frameSize'])){
                    $data['frameSize_err'] = '*enter frame size';
                }

                //validate date acquired
                if(empty($data['dateAcquired'])){
                    $data['dateAcquired_err'] = '*enter date acquired';
                }

                if(empty($data['bikeOwnerID_err']) && empty($data['frameSize_err']) && empty($data['dateAcquired_err']) && empty($data['datePutInUse_err']) && empty($data['status_err']) && empty($data['currentDA_err'])){
                    //every things up to ready 

                    // add bike
                    if($this->adminModel->addBicycleIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->bicyclesControl();
                    }else{
                        die('something went wrong');
                    }
                }
                else{
                    $this->view('admins/addBicycle', $data);
                }

            }else{
                //init data
                $data = [
                    'bikeOwnerID' => '',
                    'frameSize' => '',
                    'dateAcquired' => '',
                    'datePutInUse' => '',
                    'status' => '',
                    'currentDA' => '',
                
                    'bikeOwnerID_err' => '',
                    'frameSize_err' => '',
                    'dateAcquired_err' => '',
                    'datePutInUse_err' => '',
                    'status_err' => '',
                    'currentDA_err' => '',

                ];
                $this->view('admins/addBicycle', $data);
            }
        }

        // admin controll bicycle details
        public function bicyclesControl(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
            // load admin's DA control
            //code will implement here
            $bikeDetails = $this->adminModel->getBikeDetails();
            $data = [
                'bike_details' => $bikeDetails
            ];
        
            //view details
            $this->view('admins/bicycles', $data);
        }

        // admin views the the rides and controll
        public function ridesControl(){
            /**
             *  Task
             *      1.) handle rides in the system
             */

             //this is not load data from the database
            $this->view('admins/rides');
        }

        // admin vies the reports and controll
        public function reportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->adminModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('admins/reports', $data);
        }

        public function AccidentReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->adminModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('admins/reportsAccident', $data);
        }

        public function BicycleReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->adminModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('admins/reportsBike', $data);
        }

        public function DAReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->adminModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('admins/reportsDA', $data);
        }

        // admin views the repair and controll
        public function repairLogControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $repairLogDetails = $this->adminModel->getRepairLogDetails();
            $data = [
                'repairLog_details' => $repairLogDetails
            ];

            //this is not load data from the data
            $this->view('admins/repairLog', $data);
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
                $data['userDetailObject'] = $prespectiveUserDetail = $this->adminModel->findUserByUserID($data['userID']);
                $this->view('admins/adminViewsUserProfile', $data);
            }else{
                die("button didn't work correctly.");
            }            
        }

        //suspend process of the user by admin
        public function suspendUser(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userIdentity' => intval(trim($_POST['userIdentity']))
                ];
                
                $isUserSuspend = $this->adminModel->suspendUserByUserID($data['userIdentity']);
                if($isUserSuspend){
                    $this->view('admins/adminLandPage');
                }
            }else{
                die("some thing went wrong at the suspend process");
            }   
        }

    }