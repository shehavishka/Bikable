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

            // $bicycles = $this->riderModel->getBikeDetails();
            $map = $this->riderModel->riderLandPageMapDetails();

            $data = [
                //fetch map and all active bike details
                // 'bikeDetails' => $bicycles,
                'mapDetails' => $map
            ];

            //view details
            $this->view('riders/riderLandPage', $data);
        }

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
            $data = [
                'rideDetailObject_err' => '',
            ];
            $this->view('riders/scanQR', $data);
        }

        public function activeRide(){
            //die("it works!");
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                //if it's post, we take it as the user is creating a new ride

                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'bicycleID' => intval(trim($_POST['bicycleID'])),
                    'userLat' => $_POST['userLat'],
                    'userLong' => $_POST['userLong'],
                    // 'payMethod' => $_POST['payM'], for now we'll just use 1
                    'payMethod' => 1,
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

                    if($this->riderModel->createRide($data))
                    {
                        $data['rideLogID'] = $this->riderModel->getLastInsertedRideLogID();
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
                    'userID' => intval(trim($_GET['userID'])),
                    'rideDetailObject' => ''
                ];
                //get the ride details
                $data['rideDetailObject'] = $this->riderModel->getCurrentRideDetails($data['userID']);

                $this->view('riders/ongoingRide', $data);
            }
        }


        public function rideEnded(){
            //need to check if the user nikan came here or not. can do this by checking if there's an active ride first I suppose.
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

                //need to get the actual last payment method from the db based on the user and payment method number
                //and then charge the user

                $current_timestamp = time();
                $data['timeStamp'] = date('Y-m-d H:i:s', $current_timestamp);

                //update the ride details
                if($this->riderModel->updateRideDetails($data)){
                    $this->view('riders/rideEnded', $data);
                }else{
                    //need to replace this with a 404 page
                    die("something went wrong");
                }

            }else{
                //need to replace this with a 404 page
                die("something went wrong");
            }
        }


        public function ajax_track(){
            if (isset($_POST["req"])){
                // (F) DATABASE SETTINGS - CHANGE THESE TO YOUR OWN!
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