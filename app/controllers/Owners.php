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

        /////////////////////////////////////////////////
        // OWNER LANDPAGE ADMIN/ MECHANIC/ BICYCLE/ OWNER RIDERS, BUTTONS IMPLEMENT
        /////////////////////////////////////////////////
        // test comment

        // owner controll administrator
        public function administrator(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's administrator control
            //code will implement here

            //view details
            $this->view('owners/administrator');
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

    }