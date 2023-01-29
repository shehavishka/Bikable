<?php 
    class Administrators extends Controller{
        // owner connect to the database
        private $administratorModel;

        public function __construct(){
            // connect to the database
            // $this->administratorModel = $this->model('Administrator');
        }

        public function administratorLandPage(){
            /**
             *  Two tasks
             *      1.) Load the data
             *      2.) View the data 
            */

            // load administrator's landpage
            //code will implement here

            //view details
            $this->view('administrators/administratorLandPage');
        }

        /////////////////////////////////////////////////
        // OWNER LANDPAGE ADMIN/ MECHANIC/ BICYCLE/ OWNER RIDERS, BUTTONS IMPLEMENT
        /////////////////////////////////////////////////

    }