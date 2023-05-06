<?php 
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

        // public function error404(){
        //     $this->view('admins/error404');
        // }

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
                print_r($data['userID']. "  ");
                print_r($data['bicycleID']. "  ");
                print_r($data['userLat']. "  ");
                print_r($data['userLong']. "  ");
                print_r($current_timestamp. "  ");
                print_r($data['timeStamp']. "  ");
                print_r($data['mapDetails'][$closestPoint]->areaName. "  ". $data['mapDetails'][$closestPoint]->locationRadius. "  ");
                print_r($data['rideLogID']. "  ");
                print_r(round($distance, 5). "  ");
                print($within. " ");
                echo date_default_timezone_get();
  

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
                            //need to replace this with a 404 page
                            die("something went wrong");
                        }

                        $this->view('riders/rideEnded', $data);
                    }else{
                        //need to replace this with a 404 page
                        die("something went wrong");
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
                }

                //validate the phone number
                if(empty($data['phone'])){
                    $data['phone_Err'] = '*Please enter your phone number';
                }else if(!preg_match("/^[0-9]{10}$/", $data['phone'])){
                    $data['phone_Err'] = '*Please enter a valid phone number';
                }

                //validate the NIC
                if(empty($data['NIC'])){
                    $data['NIC_Err'] = '*Please enter your NIC';

                    // if the NIC is not empty, check if it is a valid NIC - it should have 12 numbers or 9 numbers and a v/V/x/X
                }else if(!preg_match("/^[0-9]{9}[vVxX]$/", $data['NIC']) && !preg_match("/^[0-9]{12}$/", $data['NIC'])){
                    $data['NIC_Err'] = '*Please enter a valid NIC';
                }

                //if there are no errors
                if(empty($data['name_Err']) && empty($data['email_Err']) && empty($data['phone_Err']) && empty($data['NIC_Err'])){
                    //update user details
                    if($this->riderModel->updateUserDetails($data)){
                        $data['userDetailObject'] = $this->riderModel->getUserDetails($_SESSION['user_ID']);
                        header('location: ' . URLROOT . '/riders/profilePage');
                        return;
                    }else{
                        //error page
                        die("something went wrong");
                        return;
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