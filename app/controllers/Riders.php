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
                    // 'payM' => $_POST['payM'],
                    'timeStamp' => '',
                    'mapDetails' => '',
                    'rideDetailObject' => ''
                ];

                $data['timeStamp'] = time();
                $data['mapDetails'] = $this->riderModel->riderLandPageMapDetails();
                
                //use mapDetails info to get lat and long of all docking areas and use closestPoint to find the closest area and then use withinRadius to check if it's accepted
                $points = [];
                foreach($data['mapDetails'] as $point){
                    $points[] = [$point->locationLat, $point->locationLong];
                }
                $closestPoint = $this->closestPoint($data['userLat'], $data['userLong'], $points);
                
                $within = $this->withinRadius($data['userLat'], $data['userLong'], $data['mapDetails'][$closestPoint]->locationLat, $data['mapDetails'][$closestPoint]->locationLong, $data['mapDetails'][$closestPoint]->locationRadius);
                if($within){
                    // if it's within the radius, we create the ride
                    $data['rideDetailObject'] = $this->riderModel->createRide($data);
                    $this->view('riders/ongoingRide', $data);
                }
                else{
                    //if it's not within the radius, we return an error
                    $data['rideDetailObject_err'] = 'You are not within the radius of the docking area';

                    $this->view('riders/scanQR', $data);
                }

                //testing
                print_r($data['userID']. "  ");
                print_r($data['bicycleID']. "  ");
                print_r($data['userLat']. "  ");
                print_r($data['userLong']. "  ");
                print_r($data['timeStamp']. "  ");
                print_r($data['mapDetails'][$closestPoint]->areaName. "  ". $data['mapDetails'][$closestPoint]->locationRadius. "  ");
                print((int)$within. " ");
  

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

        function withinRadius($x1, $y1, $x2, $y2, $radius) {
            
            if (($x1 == $x2) && ($y1 == $y2)) {
                return 0;
            }else{
                $theta = $y1 - $y2;
                $dist = sin(deg2rad($x1)) * sin(deg2rad($x2)) +  cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $km = $dist * 60 * 1.1515 * 1.609344;
            }
            //die($km);
            if ($km <= $radius) {
                return true;
            }else{
                return false;
            }
        }

    }