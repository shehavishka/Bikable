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
            $this->view('riders/scanQR');
        }

        public function activeRide(){
            //die("it works!");
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userID' => intval(trim($_POST['userID'])),
                    'bicycleID' => intval(trim($_POST['bicycleID'])),
                    'mapDetails' => '',
                    'timeStamp' => '',
                    'rideDetailObject' => ''
                ];

                $data['timeStamp'] = time();
                $data['mapDetails'] = $this->riderModel->riderLandPageMapDetails();
                //call create ride function
                $data['rideDetailObject'] = $this->riderModel->createRide($data['userID'], $data['bicycleID'], $data['timeStamp']);
                
                
                // print_r($data['userID']);
                // print_r($data['bicycleID']);
                // die($data['timeStamp']);
            
                $this->view('riders/ongoingRide', $data);
            }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'userID' => intval(trim($_GET['userID'])),
                    'rideDetailObject' => ''
                ];
                //get the ride details
                $data['rideDetailObject'] = $this->riderModel->getCurrentRideDetails($data['userID']);

                $this->view('riders/ongoingRide', $data);
            }
    }
}