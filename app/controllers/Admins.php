<?php 
    class Admins extends Controller{
        // admin connect to the database
        private $adminModel;

        public function __construct(){
            // connect to the database
            $this->adminModel = $this->model('Admin');
        }

        public function Login(){
            // if(SESSION)
            header('location: ' . URLROOT . '/users/login');
        }

        public function error404(){
            $this->view('admins/error404');
        }

        public function adminLandPage(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 
        
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
            $this->view('admins/adminLandPage', $data);
        }

        /////////////////////////////////////////////////
        // ADMIN LANDPAGE MECHANIC/ BICYCLE OWNER/ RIDERS, BUTTONS IMPLEMENT
        /////////////////////////////////////////////////

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////// ADD USER INTO THE SYSTEM /////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        // after addbikeOwner form filled if they are valid then insert data into the system
        public function addUser(){
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
                }else if(!is_numeric($data['nic'])){
                    $data['nic_err'] = '*NIC should be a number';
                }else if($data['nic'] < 0){
                    $data['nic_err'] = '*NIC should be a positive number';
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
                    $data['pNumber_err'] = '*enter Phone Number';
                }else if(!is_numeric($data['pNumber'])){
                    $data['pNumber_err'] = '*Phone Number should be a number';
                }else if($data['pNumber'] < 0){
                    $data['pNumber_err'] = '*Phone Number should be a positive number';
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
                    'userRole_err' => '',
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
        
        public function viewUserProfile(){
            /**
             *  Task one load the user detail button
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'userDetailObject' => ''
                ];
                $data['userDetailObject'] = $prespectiveUserDetail = $this->adminModel->findUserByUserID($data['userID']);
                $this->view('admins/viewUserProfile', $data);
            }else{
                die("button didn't work correctly.");
            }            
        }

        public function suspendUser(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userIdentity' => intval(trim($_POST['userIdentity'])),
                    'userStatus' => intval(trim($_POST['userStatus']))
                ];
                
                if($data['userStatus'] == 1){
                    $isUserSuspend = $this->adminModel->suspendUserByUserID($data['userIdentity']);
                    if($isUserSuspend){
                        header('Location:'.URLROOT.'/admins/mechanic');
                    }
                }else{
                    $isUserActive = $this->adminModel->activateUserByUserID($data['userIdentity']);
                    if($isUserActive){
                        header('Location:'.URLROOT.'/admins/mechanic');
                    }
                }
            }else{
                die("some thing went wrong with the process"); //need a 404 page here
            }   
        }

        ///////////////BIKE OWNER/////////////////////

        // after addbikeOwner form filled if they are valid then insert data into the system
        public function addBikeOwner(){
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
                }else if(!is_numeric($data['nic'])){
                    $data['nic_err'] = '*NIC should be a number';
                }else if($data['nic'] < 0){
                    $data['nic_err'] = '*NIC should be a positive number';
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
                    $data['pNumber_err'] = '*enter Phone Number';
                }else if(!is_numeric($data['pNumber'])){
                    $data['pNumber_err'] = '*Phone Number should be a number';
                }else if($data['pNumber'] < 0){
                    $data['pNumber_err'] = '*Phone Number should be a positive number';
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

        public function editBikeOwnerProfile(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'bikeOwnerID' => intval(trim($_GET['bikeOwnerID'])),
                    'userDetailObject' => '',

                    'fName' => '',
                    'lName' => '',
                    'pNumber' => '',
                    'email' => '',
                    'password' => '',
                    'nic' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    'pNumber_err' => '',
                ];
                $data['userDetailObject'] = $prespectiveUserDetail = $this->adminModel->findBikeOwnerByID($data['bikeOwnerID']);
                $this->view('admins/viewBikeOwnerProfile', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userDetailObject' => '',

                    'bikeOwnerID' => trim($_POST['bikeOwner_id']),
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
                $data['userDetailObject'] = $prespectiveUserDetail = $this->adminModel->findBikeOwnerByID($data['bikeOwnerID']);

                //validate submitted data
                    //validate first_name
                    if(empty($data['fName'])){
                        $data['fName_err'] = '*First Name is required';
                    } 

                    //validate last name
                    if(empty($data['lName'])){
                        $data['lName_err'] = '*Last Name is required';
                    }

                    //validate email
                    if(empty($data['email'])){
                        $data['email_err'] = '*Email is required';
                    }else{
                        //check weather email is availble in database
                        if($this->adminModel->findBOByEmail($data['email'])){
                            // true means that email is already taken.
                            if($data['email'] != $data['userDetailObject']->emailAdd){
                                $data['email_err'] = "*Email is already taken";
                            }
                        }else{
                            //pass
                        }
                    }


                    //validate NIC
                    if(empty($data['nic'])){
                        $data['nic_err'] = '*enter NIC number';
                    }else if(!is_numeric($data['nic'])){
                        $data['nic_err'] = '*NIC should be a number';
                    }else if($data['nic'] < 0){
                        $data['nic_err'] = '*NIC should be a positive number';
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
                        $data['pNumber_err'] = '*enter Phone Number';
                    }else if(!is_numeric($data['pNumber'])){
                        $data['pNumber_err'] = '*Phone Number should be a number';
                    }else if($data['pNumber'] < 0){
                        $data['pNumber_err'] = '*Phone Number should be a positive number';
                    }else{
                        //check weather phone number is availble in database
                        if($this->adminModel->findBOPhoneNumber($data['pNumber'])){
                            // true means that email is already taken.
                            $data['pNumber_err'] = "*Phone Number is already taken";
                        }else{
                            //pass
                        }
                    }
                //

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) && empty($data['status_err'])  && empty($data['nic_err']) && empty($data['pNumber_err']) && empty($data['userRole_err'])){
                    //every things up to ready 

                    // add bike owner
                    if($this->adminModel->updateBikeOwner($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/admins/bicycleOwner');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/admins/bicycleOwner');
                        //die('something went wrong!');
                    }
                }else{
                    $this->view('admins/viewBikeOwnerProfile', $data);
                }
 
            }else{
                die("button didn't work correctly.");
            }       
        }
        
        ///////////////DOCKING AREA/////////////////////

        // after addDA form filled if they are valid then insert data into the system
        public function addDA(){
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
                    if($this->adminModel->updateDA($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/admins/dockingareas');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/admins/dockingareas');
                        //die('something went wrong!');
                    }
                }
                else{

                    $this->view('admins/viewAreaProfile', $data);
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
        
        public function editDADetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'areaID' => intval(trim($_GET['areaID'])),
                    'areaDetailObject' => '',

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
                $data['areaDetailObject'] = $prespectiveUserDetail = $this->adminModel->findAreaByID($data['areaID']);
                $this->view('admins/viewAreaDetails', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'areaDetailObject' => '',
                    'areaID' => intval(trim($_POST['areaID'])),

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
                $data['areaDetailObject'] = $prespectiveUserDetail = $this->adminModel->findAreaByID($data['areaID']);

                //validate submitted data
                    if(empty($data['areaName'])){
                        $data['areaName_err'] = '*Area Name is Required';
                    }

                    if(empty($data['locationLat'])){
                        $data['locationLat_err'] = '*Latitude is Required';
                    }else if(!is_numeric($data['locationLat'])){
                        $data['locationLat_err'] = '*Latitude should be a number';
                    }else if($data['locationLat'] < 0){
                        $data['locationLat_err'] = '*Latitude should be a positive number';
                    }

                    if(empty($data['locationLong'])){
                        $data['locationLong_err'] = '*Longitude is Required';
                    }else if(!is_numeric($data['locationLong'])){
                        $data['locationLong_err'] = '*Longitude should be a number';
                    }else if($data['locationLong'] < 0){
                        $data['locationLong_err'] = '*Longitude should be a positive number';
                    }

                    if(empty($data['locationRadius'])){
                        $data['locationRadius_err'] = '*Location Radius is Required';
                    }else if(!is_numeric($data['locationRadius'])){
                        $data['locationRadius_err'] = '*Location Radius should be a number';
                    }else if($data['locationRadius'] < 0){
                        $data['locationRadius_err'] = '*Location Radius should be a positive number';
                    }

                    if(empty($data['traditionalAdd'])){
                        $data['traditionalAdd_err'] = '*Traditional Address is Required';
                    }

                    // if(empty($data['status'])){
                    //     $data['status_err'] = '*Status is Required';
                    // }

                    if(empty($data['currentNoOfBikes'])){
                        $data['currentNoOfBikes'] = 0;
                    }else if(!is_numeric($data['currentNoOfBikes'])){
                        $data['currentNoOfBikes_err'] = '*Current Number of Bikes should be a number';
                    }else if($data['currentNoOfBikes'] < 0){
                        $data['currentNoOfBikes_err'] = '*Current Number of Bikes should be a positive number';
                    }
                //
                

                if(empty($data['areaName_err']) && empty($data['locationLat_err']) && empty($data['locationLong_err']) && empty($data['locationRadius_err']) && empty($data['traditionalAdd_err']) && empty($data['status_err']) && empty($data['currentNoOfBikes_err'])){
                    //every things up to ready 

                    // update bike
                    if($this->adminModel->updateDA($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/admins/dockingAreas');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/admins/dockingAreas');
                        // die('something went wrong!');
                    }
                }
                else{
                    // die($data['areaName_err'].$data['locationLat_err'].$data['locationLong_err'].$data['locationRadius_err'].$data['traditionalAdd_err'].$data['status_err'].$data['currentNoOfBikes_err']);
                    $this->view('admins/viewAreaDetails', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }
        
        ///////////////BICYCLE/////////////////////

        // after addbike form filled if they are valid then insert data into the system
        public function addBicycle(){
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
                        // $this->bicyclesControl();
                        header('Location:'.URLROOT.'/admins/bicyclesControl');
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

        public function editBicycleDetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'bicycleID' => intval(trim($_GET['bicycleID'])),
                    'bicycleDetailObject' => '',

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
                $data['bicycleDetailObject'] = $prespectiveUserDetail = $this->adminModel->findBicycleByID($data['bicycleID']);
                $this->view('admins/viewBicycleDetails', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'bicycleDetailObject' => '',
                    
                    'bicycleID' => intval(trim($_POST['bicycleID'])),
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
                $data['bicycleDetailObject'] = $prespectiveUserDetail = $this->adminModel->findBicycleByID($data['bicycleID']);
                //validate submitted data
                    //validate bicycle owner ID
                    if(empty($data['bikeOwnerID'])){
                        $data['bikeOwnerID_err'] = '*Bike Owner ID is Required';
                    } 

                    //validate frame size
                    if(empty($data['frameSize'])){
                        $data['frameSize_err'] = '*Frame Size is required';
                    }else if(!is_numeric($data['frameSize'])){
                        $data['frameSize_err'] = '*Frame Size must be a number';
                    }

                    //validate date acquired
                    if(empty($data['dateAcquired'])){
                        $data['dateAcquired_err'] = '*Date Acquired is required';
                    }

                    //validate DA
                    if(empty($data['currentDA'])){
                        $data['currentDA_err'] = '*Current Docking Area is required';
                    }else if(!is_numeric($data['currentDA'])){
                        $data['currentDA_err'] = '*Current Docking Area must be a number';
                    }
                //
                

                if(empty($data['bikeOwnerID_err']) && empty($data['frameSize_err']) && empty($data['dateAcquired_err']) && empty($data['datePutInUse_err']) && empty($data['status_err']) && empty($data['currentDA_err'])){
                    //every things up to ready 

                    // update bike
                    if($this->adminModel->updateBicycle($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/admins/bicyclesControl');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/admins/bicyclesControl');
                        //die('something went wrong!');
                    }
                }
                else{
                    $this->view('admins/viewBicycleDetails', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }

        ///////////////RIDES/////////////////////

        //admin views the the rides and controll
        public function ridesControl(){
            /**
             *  Task
             *      1.) handle rides in the system
             */
            $rideDetails = $this->adminModel->getRideDetails();
            $data = [
                'ride_details' => $rideDetails
            ];

             //this is not load data from the database
            $this->view('admins/rides', $data);
        }

        ///////////////REPORT/////////////////////

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

        public function editReportDetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'reportID' => intval(trim($_GET['reportID'])),
                    'reportDetailObject' => '',

                    'mechanicID' => '',
                    'mechanicID_err' => '',
                ];
                $data['reportDetailObject'] = $prespectiveUserDetail = $this->adminModel->findReportByID($data['reportID']);
                $this->view('admins/viewReport', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'reportDetailObject' => '',
                    
                    'reportID' => intval(trim($_POST['reportID'])),
                    'mechanicID' => trim($_POST['mechanicID']),
                    'mechanicID_err' => '',
                ];
                $data['reportDetailObject'] = $prespectiveUserDetail = $this->adminModel->findReportByID($data['reportID']);
                
                //validate submitted data
                    //validate mechanic ID
                    if(empty($data['mechanicID'])){
                        $data['mechanicID_err'] = '*Mechanic ID is Required';
                    }else if(!is_numeric($data['mechanicID'])){
                        $data['mechanicID_err'] = '*Mechanic ID must be a number';
                    }else if($data['mechanicID'] < 0){
                        $data['mechanicID_err'] = '*Mechanic ID must be a positive number';
                    }
                //

                if(empty($data['mechanicID_err'])){
                    //every things up to ready 

                    // update bike
                    if($this->adminModel->assignReportMechanic($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/admins/reportsControl');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/admins/reportsControl');
                        //die('something went wrong!');
                    }
                }
                else{
                    $this->view('admins/viewReport', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }

        ///////////////REPAIR LOG/////////////////////

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

        public function viewRepairLog(){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'logID' => intval(trim($_GET['logID'])),
                    'logDetailObject' => ''
                ];
                $data['logDetailObject'] = $prespectiveUserDetail = $this->adminModel->findLogbyID($data['logID']);
                $this->view('admins/viewRepairLog', $data);
            }else{
                die("button didn't work correctly.");
            }            
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

    //     public function viewUserPersonallyPenButton(){
    //         /**
    //          *  Task one load the user detail button
    //         */
    //         if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //             $data = [
    //                 'userID' => intval(trim($_POST['userID'])),
    //                 'userDetailObject' => ''
    //             ];
    //             $data['userDetailObject'] = $prespectiveUserDetail = $this->adminModel->findUserByUserID($data['userID']);
    //             $this->view('admins/adminViewsUserProfile', $data);
    //         }else{
    //             die("button didn't work correctly.");
    //         }            
    //     }

    //     //suspend process of the user by admin
    //     public function suspendUser(){

    //         if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //             $data = [
    //                 'userIdentity' => intval(trim($_POST['userIdentity']))
    //             ];
                
    //             $isUserSuspend = $this->adminModel->suspendUserByUserID($data['userIdentity']);
    //             if($isUserSuspend){
    //                 $this->view('admins/adminLandPage');
    //             }
    //         }else{
    //             die("some thing went wrong at the suspend process");
    //         }   
    //     }

    }