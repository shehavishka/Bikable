<?php 
    class Owners extends Controller{
        // owner connect to the database
        private $ownerModel;

        public function __construct(){
            // connect to the database
            // $this->ownerModel = $this->model('Owner');
        }

        public function ownerLandPage(){
            /**
             *  Two tasks
             *      1.) Load the data
             *      2.) View the data 
            */

            // load owner's landpage
            //code will implement here

            //view details
            $this->view('owners/ownerLandPage');
        }
    }