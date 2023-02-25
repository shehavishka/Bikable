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

            $bicycles = $this->riderModel->getBikeDetails();
            $map = $this->riderModel->riderLandPageMapDetails();

            $data = [
                //fetch map and all active bike details
                'bikeDetails' => $bicycles,
                'mapDetails' => $map
            ];

            //view details
            $this->view('riders/riderLandPage', $data);
        }

        public function scanQR(){
            $this->view('riders/scanQR');
        }
    }