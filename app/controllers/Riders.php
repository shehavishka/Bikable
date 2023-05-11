<?php 
    // Riders controller class 23-05-11
    // 1.	riderLandPage
    // 2.	getMapDADetails
    // 3.	scanQR
    // 4.	activeRide
    // 5.	rideEnded
    // 6.	track_user
    // 7.	profilePage
    // 8.	profileEdit
    // 9.	viewHistory
    // 10.	viewReports
    // 11.	createReport
    // 12.	editReport
    // 13.	deleteReport
    // 14.	changePassword
    // 15.	deleteAccount
    // 16.	closestPoint
    // 17.	withinRadius
    // 18.	distance
    // 19.	redirectIfActive
    // 20.  landToErrorPage
    // 21.	class - Track

    
    class Riders extends Controller{
        // rider connect to the database
        private $riderModel;

        public function __construct(){
            // connect to the database
            $this->riderModel = $this->model('Rider');
        }

        public function Login(){
            // if(SESSION)
            header('location: ' . URLROOT . '/users/login');
        }

        public function riderLandPage(){
            //check if a ride is already active and the user simply refreshed the page
            if($this->redirectIfActive()){
                return;
            }
            
            $map = $this->riderModel->riderLandPageMapDetails();

            $data = [
                //fetch map and all active bike details
                // 'bikeDetails' => $bicycles,
                'mapDetails' => $map
            ];

            //view details
            $this->view('riders/riderLandPage', $data);
        }

        //for the xhttp on the rider land page
        public function getMapDADetails(){
            $id = $_GET['q'];
            $lat = $_GET['lat'];
            $long = $_GET['long'];

            // echo($lat);

            $data = $this->riderModel->getDADetails($id);

            //calculate the distance between the user and the docking area
            $distance = $this->distance($lat, $long, $data->locationLat, $data->locationLong);

            //add the distance to the data object rounded to 2 decimal places
            $data->distance = round($distance, 2);

            //send the data var back to xhttp as a encoded json
            echo json_encode($data);
        }

        public function scanQR(){
            //check if a ride is already active and the user simply refreshed the page
            if($this->redirectIfActive()){
                return;
            }

            $data = [
                'rideDetailObject_err' => '',
            ];
            $this->view('riders/scanQR', $data);
        }

        public function activeRide(){
            //die("it works!");
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //if it's post, we take it as the user is creating a new ride

                //check if a ride is already active and the user simply refreshed the page
                if($this->redirectIfActive()){
                    return;
                }

                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'bicycleID' => intval(trim($_POST['bicycleID'])),
                    'userLat' => $_POST['userLat'],
                    'userLong' => $_POST['userLong'],
                    // 'payMethod' => $_POST['payM'], for now we'll just use 1
                    'payMethod' => 1,
                    //fare base value and rate should come from the database, but for now we'll just use 150 and 0.2
                    'fareBaseValue' => 150,
                    'fareRate' => 0.2,
                    'startArea' => '',
                    'timeStamp' => '',
                    'mapDetails' => '',
                    'rideLogID' => '',

                    'rideDetailObject_err' => '',
                ];

                $current_timestamp = time();
                $data['timeStamp'] = date('Y-m-d H:i:s', $current_timestamp);
                
                $data['mapDetails'] = $this->riderModel->riderLandPageMapDetails();
                
                //use mapDetails info to get lat and long of all docking areas and use closestPoint to find the closest area and then use withinRadius to check if it's accepted
                $points = [];
                foreach($data['mapDetails'] as $point){
                    $points[] = [$point->locationLat, $point->locationLong];
                }
                $closestPoint = $this->closestPoint($data['userLat'], $data['userLong'], $points);
                $distance = $this->distance($data['userLat'], $data['userLong'], $data['mapDetails'][$closestPoint]->locationLat, $data['mapDetails'][$closestPoint]->locationLong);
                $within = $this->withinRadius($distance, $data['mapDetails'][$closestPoint]->locationRadius);
                if($within){
                    // if it's within the radius, we create the ride
                    $data['startArea'] = $data['mapDetails'][$closestPoint]->areaID;

                    //update the bike and docking area in question to reflect the removal of a bike and the new status of the bike
                    if($this->riderModel->updateBikeStatus($data['bicycleID'], 1)){
                        $this->riderModel->updateDockingAreaBikeCount($data['startArea'], 2);
                    }else{
                        $data['rideDetailObject_err'] = 'Bicycle not available. Please try another bicycle.';
                        $this->view('riders/scanQR', $data);
                        return;
                    }

                    if($this->riderModel->createRide($data))
                    {
                        $data['rideLogID'] = $this->riderModel->getLastInsertedRideLogID();

                        //fetch ride details just to make the rideDetailObject the right class
                        $data['rideDetailObject'] = $this->riderModel->getRideDetails($data['rideLogID']);
                        //enter static fare value -> this should come from the super owner technically
                        // $data['rideDetailObject']->fare = 149.80;
                        // $data['rideDetailObject']->timeTravelled = -10;

                        $this->view('riders/ongoingRide', $data);
                    }
                }
                else{
                    //if it's not within the radius, we return an error
                    $data['rideDetailObject_err'] = 'You are not within the radius of the docking area';

                    $this->view('riders/scanQR', $data);
                }

                //for testing. this stuff gets printed behind the map
                // print_r($data['userID']. "  ");
                // print_r($data['bicycleID']. "  ");
                // print_r($data['userLat']. "  ");
                // print_r($data['userLong']. "  ");
                // print_r($current_timestamp. "  ");
                // print_r($data['timeStamp']. "  ");
                // print_r($data['mapDetails'][$closestPoint]->areaName. "  ". $data['mapDetails'][$closestPoint]->locationRadius. "  ");
                // print_r($data['rideLogID']. "  ");
                // print_r(round($distance, 5). "  ");
                // print($within. " ");
                // echo date_default_timezone_get();
  

            }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
                //if it's get, we take it as the user is requesting the current ride details

                $data = [                    
                    'userID' => $_SESSION['user_ID'],
                    'rideLogID' => intval(trim($_GET['rideLogID'])),
                    'bicycleID' => '',
                    'payMethod' => '',
                    //fare base value and rate should come from the database, but for now we'll just use 150 and 0.2
                    'fareBaseValue' => 150,
                    'fareRate' => 0.2,
                    'mapDetails' => '',
                    'rideDetailObject' => ''
                ];

                $data['mapDetails'] = $this->riderModel->riderLandPageMapDetails();

                //get the ride details
                $data['rideDetailObject'] = $this->riderModel->getRideDetails($data['rideLogID']);
                
                //if rideDetailObject has a value, proceed to page, else redirect to header('location: ' . URLROOT . '/riders/riderLandPage');
                if($data['rideDetailObject']){

                    if($data['rideDetailObject']->status == 1){
                        //if the ride is still ongoing, we redirect to the ongoing ride page
                        $data['bicycleID'] = $data['rideDetailObject']->bicycleID;
                        $data['payMethod'] = $data['rideDetailObject']->payMethod;
                        $data['timeStamp'] = $data['rideDetailObject']->rideStartTimeStamp;
    
                        $this->view('riders/ongoingRide', $data);
                    }else{
                        header('location: ' . URLROOT . '/riders/riderLandPage');
                    }

                }else{
                    header('location: ' . URLROOT . '/riders/riderLandPage');
                }
            }else{
                //if it's neither, we redirect to the rider landing page
                header('location: ' . URLROOT . '/riders/riderLandPage');
            }
        }


        public function rideEnded(){
            //need to check if the user nikan came here or not. we assume that the user cannot replicate the post request
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'rideLogID' => intval(trim($_POST['rideLogID'])),
                    'userID' => intval(trim($_POST['userID'])),
                    'bicycleID' => intval(trim($_POST['bicycleID'])),
                    'endArea' => intval(trim($_POST['endArea'])),
                    'time_spent' => intval(trim($_POST['time_spent'])),
                    'fare' => trim($_POST['current_fare']),
                    'payMethod' => intval(trim($_POST['payMethod'])),
                    'timeStamp' => '',
                ];

                //check if the ride is still active
                $status = $this->riderModel->checkRideStatus($data['rideLogID']);

                if($status->status == 1){  
                    
                    //need to get the actual last payment method from the db based on the user and payment method number
                    //and then charge the user
                    
                    
                    $current_timestamp = time();
                    $data['timeStamp'] = date('Y-m-d H:i:s', $current_timestamp);
                    
                    //update the ride details
                    if($this->riderModel->updateRideDetails($data)){

                        //update the bike and docking area in question to reflect the addition of a bike and the new status of the bike
                        if($this->riderModel->updateBikeStatus($data['bicycleID'], 0)){
                            $this->riderModel->updateDockingAreaBikeCount($data['endArea'], 1);
                        }else{
                            // redirect to error page
                            $this->landToErrorPage();
                            die();
                        }

                        $this->view('riders/rideEnded', $data);
                    }else{
                        // redirect to error page
                        $this->landToErrorPage();
                        die();
                    }
                }else{
                    $this->view('riders/rideEnded', $data);
                }

            }else{
                //redirect to the rider landing page
                header('location: ' . URLROOT . '/riders/riderLandPage');
            }
        }


        public function track_user(){
            if (isset($_POST["req"])){
                // (F) DATABASE SETTINGS
                define("DB_CHARSET", "utf8mb4");
                define("DB_PASSWORD", "");
                
                // (G) START!
                $_TRACK = new Track();


                //THE actual updating bit
                switch ($_POST["req"]) {
                    // (A) UPDATE RIDER LOCATION ----For Rider
                    case "update":
                    echo $_TRACK->update($_POST["id"], $_POST["rideLogID"], $_POST["lng"], $_POST["lat"])
                        ? "OK" : $_TRACK->error ;
                    break;

                    // (B) GET RIDER(S) LAST KNOWN LOCATION ----For Admin
                    case "get":
                    echo json_encode($_TRACK->get(isset($_POST["id"]) ? $_POST["id"] : null));
                    break;
                }
            }
        }

        public function profilePage(){
            $data = [
                'userDetailObject' => '',
                'name_Err' => '',
                'email_Err' => '',
                'phone_Err' => '',
                'NIC_Err' => '',
                'password_Err' => '',
            ];

            $data['userDetailObject'] = $this->riderModel->getUserDetails($_SESSION['user_ID']);

            $this->view('riders/viewProfile', $data);
        }

        public function profileEdit(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'phone' => trim($_POST['phone']),
                    'NIC' => trim($_POST['NIC']),
                    'fName' => '',
                    'lName' => '',

                    'userDetailObject' => '',

                    'name_Err' => '',
                    'email_Err' => '',
                    'phone_Err' => '',
                    'NIC_Err' => '',
                ];

                //split the name into first and last name
                
                //validate the name
                if(empty($data['name'])){
                    $data['name_Err'] = '*Please enter your name';
                }else if(!preg_match("/^[a-zA-Z ]*$/", $data['name'])){
                    $data['name_Err'] = '*Please enter a valid name';
                }else{
                    $name = explode(" ", $data['name']);
                    //check that exactly 2 names were entered
                    if(count($name) == 2){
                        $data['fName'] = $name[0];
                        $data['lName'] = $name[1];
                    }else{
                        $data['name_Err'] = '*Please enter exactly two names';
                    }
                }

                //validate the email
                if(empty($data['email'])){
                    $data['email_Err'] = '*Please enter your email';
                }else if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $data['email_Err'] = '*Please enter a valid email';
                }else{
                    if($this->riderModel->findUserByEmail($data['email']) && $data['email'] != $_SESSION['user_email']){
                        $data['email_err'] = "*Email is already registered";
                    }
                }

                //validate the phone number
                if(empty($data['phone'])){
                    $data['phone_Err'] = '*Please enter your phone number';
                }else if(!preg_match("/^[0-9]{10}$/", $data['phone'])){
                    $data['phone_Err'] = '*Please enter a valid phone number';
                }else{
                    if($this->riderModel->findPhoneNumber($data['phone']) && $data['phone'] != $_SESSION['user_pNumber']){
                        $data['phone_err'] = "*Phone number is already registered";
                    }else{
                        //update phone number
                        //pass
                    }
                }

                //validate the NIC
                if(empty($data['NIC'])){
                    $data['NIC_Err'] = '*Please enter your NIC';

                    // if the NIC is not empty, check if it is a valid NIC - it should have 12 numbers or 9 numbers and a v/V/x/X
                }else if(!preg_match("/^[0-9]{9}[vVxX]$/", $data['NIC']) && !preg_match("/^[0-9]{12}$/", $data['NIC'])){
                    $data['NIC_Err'] = '*Please enter a valid NIC';
                }else{
                    if($this->riderModel->findNicNumber($data['NIC']) && $data['NIC'] != $_SESSION['user_NIC']){
                        $data['nic_err'] = "*NIC is already registered";
                    }else{
                        //update nic
                        //pass
                    }
                }

                //if there are no errors
                if(empty($data['name_Err']) && empty($data['email_Err']) && empty($data['phone_Err']) && empty($data['NIC_Err'])){
                    //update user details
                    if($this->riderModel->updateUserDetails($data)){
                        $data['userDetailObject'] = $this->riderModel->getUserDetails($_SESSION['user_ID']);
                        header('location: ' . URLROOT . '/riders/profilePage');
                        return;
                    }else{
                        // redirect to error page
                        $this->landToErrorPage();
                        die();
                    }
                }else{
                    //load the view with errors
                    $data['userDetailObject'] = $this->riderModel->getUserDetails($_SESSION['user_ID']);
                    $this->view('riders/editProfile', $data);
                    return;
                }
            }

            $data = [
                'userDetailObject' => '',
                'name_Err' => '',
                'email_Err' => '',
                'phone_Err' => '',
                'NIC_Err' => '',
                'password_Err' => '',
            ];

            $data['userDetailObject'] = $this->riderModel->getUserDetails($_SESSION['user_ID']);

            $this->view('riders/editProfile', $data);
        }

        public function viewHistory(){
            $data=[
                'rideHistoryDetailObject' => '',
                'mapDetails' => '',
            ];
            
            $data['rideHistoryDetailObject'] = $this->riderModel->getRideHistory($_SESSION['user_ID']);
            $data['mapDetails'] = $this->riderModel->getAllMapDetails();

            $this->view('riders/rideHistory', $data);
        }

        public function viewReports(){
            $data=[
                'reportsDetailObject' => '',
            ];
            
            $data['reportsDetailObject'] = $this->riderModel->getReportsDetails($_SESSION['user_ID']);

            $this->view('riders/viewReports', $data);
        }

        public function createReport(){
            $data = [
                'type' => '',
                'problemTitle' => '',
                'problemDescription' => '',
                'areaID' => '',
                'accidentLocation' => '',
                'date' => '',
                'time' => '',
                'bicycleID' => '',
                'image' => '',

                'accidentTimeStamp' => '',

                'type_Err' => '',
                'problemTitle_Err' => '',
                'problemDescription_Err' => '',
                'areaID_Err' => '',
                'accidentLocation_Err' => '',
                'date_Err' => '',
                'time_Err' => '',
                'bicycleID_Err' => '',
                'image_Err' => '',

                'mapDetails' => '',
            ];
            $data['mapDetails'] = $this->riderModel->getAllMapDetails();

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //get the data from the form
                if($_POST['type']){$data['type'] = $_POST['type'];}
                $data['problemTitle'] = $_POST['problemTitle'];
                $data['problemDescription'] = $_POST['problemDescription'];
                if($_POST['areaID']){$data['areaID'] = $_POST['areaID'];}
                $data['accidentLocation'] = $_POST['accidentLocation'];
                $data['date'] = $_POST['date'];
                $data['time'] = $_POST['time'];
                $data['bicycleID'] = $_POST['bicycleID'];
                // $data['image'] = $_POST['image'];

                //validate the report type
                if(empty($data['type'])){
                    $data['type_Err'] = '*Please select a report type';
                }

                //validate the report title
                if(empty($data['problemTitle'])){
                    $data['problemTitle_Err'] = '*Please enter a title';
                }

                //validate the report description
                if(empty($data['problemDescription'])){
                    $data['problemDescription_Err'] = '*Please enter a description';
                }

                //if type = docking area issue, validate the area ID    
                if($data['type'] == 'Area'){
                    if(empty($data['areaID'])){
                        $data['areaID_Err'] = '*Please select an area';
                    }
                }

                //if type = accident, validate the accident location, date, time and bike
                if($data['type'] == 'Accident'){
                    if(empty($data['accidentLocation'])){
                        $data['accidentLocation_Err'] = '*Please enter an accident location';
                    }
                    if(empty($data['date'])){
                        $data['date_Err'] = '*Please select a date';
                        // else if date is after today
                    }else if($data['date'] > date("Y-m-d")){
                        $data['date_Err'] = '*Please select a valid date';
                    }
                    // print_r($data['date']);
                    // print_r(date("Y-m-d"));
                    if(empty($data['time'])){
                        $data['time_Err'] = '*Please select a time';
                    }
                    if(empty($data['bicycleID'])){
                        $data['bicycleID_Err'] = '*Please scan the bicycle';
                    }

                    // concatenate date and time to timestamp format
                    $data['accidentTimeStamp'] = $data['date'] . ' ' . $data['time'];
                }else{
                    $data['date'] = '';
                }

                //if type = bicycle, validate the bikeID
                if($data['type'] == 'Bicycle'){
                    if(empty($data['bicycleID'])){
                        $data['bicycleID_Err'] = '*Please scan the bicycle';
                    }
                }

                // if image size is larger than 5MB
                // if($_FILES['image']['size'] > 5242880){
                //     $data['image_Err'] = '*Image size should be less than 5MB';
                // }

                //if there are no errors 
                if(empty($data['type_Err']) && empty($data['problemTitle_Err']) && empty($data['problemDescription_Err']) && empty($data['areaID_Err']) && empty($data['accidentLocation_Err']) && empty($data['date_Err']) && empty($data['time_Err']) && empty($data['bicycleID_Err']) && empty($data['image_Err'])){
                    //create the report
                    // print_r($data);

                    if($this->riderModel->createReport($data)){
                        header('location: ' . URLROOT . '/riders/viewReports');
                        return;
                    }else{
                        // redirect to error page
                        $this->landToErrorPage();
                        die();
                    }
                }else{
                    //load the view with errors
                    $this->view('riders/createReport', $data);
                    return;
                }
            }

            $this->view('riders/createReport', $data);            
        }

        public function editReport(){
            $data = [
                'reportID' => '',
                'type' => '',
                'problemTitle' => '',
                'problemDescription' => '',
                'areaID' => '',
                'accidentLocation' => '',
                'date' => '',
                'time' => '',
                'bicycleID' => '',
                'image' => '',

                'accidentTimeStamp' => '',

                'type_Err' => '',
                'problemTitle_Err' => '',
                'problemDescription_Err' => '',
                'areaID_Err' => '',
                'accidentLocation_Err' => '',
                'date_Err' => '',
                'time_Err' => '',
                'bicycleID_Err' => '',
                'image_Err' => '',

                'mapDetails' => '',
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //validate and update the report
                //get the data from the form
                $data['reportID'] = $_POST['reportID'];
                if($_POST['type']){$data['type'] = $_POST['type'];}
                $data['problemTitle'] = $_POST['problemTitle'];
                $data['problemDescription'] = $_POST['problemDescription'];
                if($_POST['areaID']){$data['areaID'] = $_POST['areaID'];}
                $data['accidentLocation'] = $_POST['accidentLocation'];
                $data['date'] = $_POST['date'];
                $data['time'] = $_POST['time'];
                $data['bicycleID'] = $_POST['bicycleID'];
                // $data['image'] = $_POST['image'];

                //validate the report type
                if(empty($data['type'])){
                    $data['type_Err'] = '*Please select a report type';
                }

                //validate the report title
                if(empty($data['problemTitle'])){
                    $data['problemTitle_Err'] = '*Please enter a title';
                }

                //validate the report description
                if(empty($data['problemDescription'])){
                    $data['problemDescription_Err'] = '*Please enter a description';
                }

                //if type = docking area issue, validate the area ID    
                if($data['type'] == 'Area'){
                    if(empty($data['areaID'])){
                        $data['areaID_Err'] = '*Please select an area';
                    }
                }

                //if type = accident, validate the accident location, date, time and bike
                if($data['type'] == 'Accident'){
                    if(empty($data['accidentLocation'])){
                        $data['accidentLocation_Err'] = '*Please enter an accident location';
                    }
                    if(empty($data['date'])){
                        $data['date_Err'] = '*Please select a date';
                        // else if date is after today
                    }else if($data['date'] > date("Y-m-d")){
                        $data['date_Err'] = '*Please select a valid date';
                    }
                    // print_r($data['date']);
                    // print_r(date("Y-m-d"));
                    if(empty($data['time'])){
                        $data['time_Err'] = '*Please select a time';
                    }
                    if(empty($data['bicycleID'])){
                        $data['bicycleID_Err'] = '*Please scan the bicycle';
                    }

                    // concatenate date and time to timestamp format
                    $data['accidentTimeStamp'] = $data['date'] . ' ' . $data['time'];
                }else{
                    $data['date'] = '';
                }

                //if type = bicycle, validate the bikeID
                if($data['type'] == 'Bicycle'){
                    if(empty($data['bicycleID'])){
                        $data['bicycleID_Err'] = '*Please scan the bicycle';
                    }
                }

                //if there are no errors 
                if(empty($data['type_Err']) && empty($data['problemTitle_Err']) && empty($data['problemDescription_Err']) && empty($data['areaID_Err']) && empty($data['accidentLocation_Err']) && empty($data['date_Err']) && empty($data['time_Err']) && empty($data['bicycleID_Err']) && empty($data['image_Err'])){
                    if($this->riderModel->updateReport($data)){
                        header('location: ' . URLROOT . '/riders/viewReports');
                        return;
                    }else{
                        // redirect to error page
                        $this->landToErrorPage();
                        die();
                    }
                }else{
                    //load the view with errors
                    $this->view('riders/editReport', $data);
                    return;
                }
                
            }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data['mapDetails'] = $this->riderModel->getAllMapDetails();
                $data['reportID'] = $_GET['reportID'];

                $report = $this->riderModel->getReportByID($data['reportID']);
                $data['type'] = $report->reportType;
                $data['problemTitle'] = $report->problemTitle;
                $data['problemDescription'] = $report->problemDescription;
                $data['areaID'] = $report->areaID;
                $data['accidentLocation'] = $report->accidentLocation;
                $data['bicycleID'] = $report->bicycleID;    
                $data['accidentTimeStamp'] = $report->accidentTimeApprox;
                
                // split the timestamp into date and time
                $data['date'] = substr($data['accidentTimeStamp'], 0, 10);
                $data['time'] = substr($data['accidentTimeStamp'], 11, 21);

                // print_r($data['date'] . " " . $data['time'] . " " . $data['accidentTimeStamp'] . " " . $report->accidentTimeApprox . " test");
                // die("hlello?");

                $this->view('riders/editReport', $data);
            }
        }

        //function to delete a report
        public function deleteReport(){
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                    $reportID = $_GET['reportID'];

                if($this->riderModel->deleteReport($reportID)){
                    header('location: ' . URLROOT . '/riders/viewReports');
                    return;
                }else{
                    // redirect to error page
                    $this->landToErrorPage();
                    die();
                }
            }else{
                header('location: ' . URLROOT . '/riders/viewReports');
                return;
            }
        }

        public function changePassword(){
            $data = [
                'oldPassword' => '',
                'newPassword' => '',
                'confirmPassword' => '',
                'oldPassword_Err' => '',
                'newPassword_Err' => '',
                'confirmPassword_Err' => ''
            ];

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //sanitize the input
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                //get the data
                $data['oldPassword'] = trim($_POST['oldPassword']);
                $data['newPassword'] = trim($_POST['newPassword']);
                $data['confirmPassword'] = trim($_POST['confirmPassword']);

                //validate the old password
                if(empty($data['oldPassword'])){
                    $data['oldPassword_Err'] = '*Please enter your old password';
                }else{
                    if(!$this->riderModel->checkPassword($data['oldPassword'])){
                        $data['oldPassword_Err'] = '*Incorrect password';
                    }
                }

                //validate the new password
                if(empty($data['newPassword'])){
                    $data['newPassword_Err'] = '*Please enter a new password';
                }else if(strlen($data['newPassword']) < 8){
                    $data['newPassword_Err'] = '*Password must be at least 8 characters';
                }

                //validate the confirm password
                if(empty($data['confirmPassword'])){
                    $data['confirmPassword_Err'] = '*Please confirm your password';
                }else{
                    if($data['newPassword'] != $data['confirmPassword']){
                        $data['confirmPassword_Err'] = '*Passwords do not match';
                    }
                }

                //if there are no errors
                if(empty($data['oldPassword_Err']) && empty($data['newPassword_Err']) && empty($data['confirmPassword_Err'])){
                    if($this->riderModel->changePassword($data['newPassword'])){
                        header('location: ' . URLROOT . '/riders/profilePage');
                        return;
                    }else{
                        // redirect to error page
                        $this->landToErrorPage();
                        die();
                    }
                }else{
                    //load the view with errors
                    $this->view('riders/changePassword', $data);
                    return;
                }
            }else{
                $this->view('riders/changePassword', $data);
            }
        }

        public function deleteAccount(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $userID = $_POST['userID'];
                
                if($this->riderModel->deleteUser($userID)){
                    header('location: ' . URLROOT . '/riders/logout');
                    return;
                }else{
                    // redirect to error page
                    $this->landToErrorPage();
                    die();
                }
            }else{
                $this->view('riders/deleteAccount');
            }
        }

        /////////////////Internal functions

        //function to find the closest point to a given point on a cartesian plane
        //inputs: x and y coordinates of the point, and an array of points
        //output: the index of the closest point in the array
        function closestPoint($x, $y, $points) {
            //convert x  and y from lat long to cartesian

            $closest = 0;
            $distance = 0;
            $minDistance = 0;
            foreach ($points as $key => $point) {
                $distance = sqrt(pow($x - $point[0], 2) + pow($y - $point[1], 2));
                if ($distance < $minDistance || $minDistance == 0) {
                    $minDistance = $distance;
                    $closest = $key;
                }
            }
            return $closest;
        }

        //function to check if a point is within a certain radius of another
        //inputs: x and y coordinates of two points, radius
        //output: true or false

        function withinRadius($km, $radius) {
            
            // if (($x1 == $x2) && ($y1 == $y2)) {
            //     return 0;
            // }else{
            //     $theta = $y1 - $y2;
            //     $dist = sin(deg2rad($x1)) * sin(deg2rad($x2)) +  cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($theta));
            //     $dist = acos($dist);
            //     $dist = rad2deg($dist);
            //     $km = $dist * 60 * 1.1515 * 1.609344;
            // }
            //die($km);
            if ($km <= $radius) {
                return 1;
            }else{
                return 0;
            }
        }

        function distance($x1, $y1, $x2, $y2) {
            
            if (($x1 == $x2) && ($y1 == $y2)) {
                return 0;
            }else{
                $theta = $y1 - $y2;
                $dist = sin(deg2rad($x1)) * sin(deg2rad($x2)) +  cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $km = $dist * 60 * 1.1515 * 1.609344;
            }
            return $km;
        }

        function redirectIfActive(){
            if(isset($_SESSION['user_ID'])){
                $currentRide = $this->riderModel->checkIfActive($_SESSION['user_ID']);
                if($currentRide){
                    //got to ongoing ride page with userID as a get request
                    header('location: ' . URLROOT . '/riders/activeRide?rideLogID=' . $currentRide->rideLogID);
                    return true;
                }else{
                    return false;
                }
            }else{
                header('location: ' . URLROOT . '/users/login');
            }
        }

        public function landToErrorPage(){
            //load the error page only view
            $this->view('users/error');
        }

    }

    ////////////////////////////////////////TRACK CLASS

    class Track {
        // (A) CONSTRUCTOR - CONNECT TO DATABASE
        public $pdo = null;
        public $stmt = null;
        public $error = "";
        function __construct () {
          $this->pdo = new PDO(
            "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
            DB_USER, DB_PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
          ]);
        }
      
        // (B) DESTRUCTOR - CLOSE CONNECTION
        function __destruct () {
          if ($this->stmt !== null) { $this->stmt = null; }
          if ($this->pdo !== null) { $this->pdo = null; }
        }
      
        // (C) HELPER FUNCTION - EXECUTE SQL QUERY
        function query ($sql, $data=null) {
          $this->stmt = $this->pdo->prepare($sql);
          $this->stmt->execute($data);
        }
      
        // (D) UPDATE RIDER COORDINATES
        function update ($id, $rideLogID, $lng, $lat) {
          $this->query(
            "UPDATE `ridelog` SET `locationUpdateTimestamp` = ?, `currentLong` = ?, `currentLat` = ? WHERE `rideLogID` = ?",
            [date("Y-m-d H:i:s"), $lng, $lat, $rideLogID]
          );
          return true;
        }
      
        // (E) GET RIDER(S) COORDINATES
        function get ($id=null) {
          $this->query(
            "SELECT * FROM `ridelog`" . ($id==null ? "" : " WHERE `riderID`=?"),
            $id==null ? null : [$id]
          );
          return $this->stmt->fetchAll();
        }
    }

?>