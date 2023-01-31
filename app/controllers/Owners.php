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

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////// ADD USER INTO THE SYSTEM /////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        public function addUserToTheSystemButton(){
            /**
             *  Two tasks 1
             *      1.) Load the form      
            */

            // load the data form UI
            $this->view('owners/addUser');
        }

        // after addUser form filled if they are valid then insert data into the system
        public function addUserToTheSystemFormSubmitButton(){
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
                    'userRole' => trim($_POST['user_role']),

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'status_err' => '',
                    'nic_err' => '',
                    'pNumber_err' => '',
                    'userRole_err' => ''
                ];
            }

        }


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

        // owner controll Mechanic data view
        public function mechanic(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here

            //view details
            $this->view('owners/mechanic');
        }

        // owner controll Mechanic data view
        public function riders(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here

            //view details
            $this->view('owners/riders');
        }

        public function bicycleOwner(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here

            //view details
            $this->view('owners/bicycleOwner');
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

        // owner controll docking areas
        public function dockingAreas(){
            /**
             * Task
             *      1.) add docking area to the system
             */

            //this is not load data from the database
            $this->view('owners/dockingareas');
        }

        // owner controll bicycle details
        public function bicyclesControl(){
            /**
             * Task 
             *      1.) handle bicycles in the system.
             */

            //this is not load data from the database
            $this->view('owners/bicycles');
        }

        // owner views the the rides and controll
        public function ridesControl(){
            /**
             *  Task
             *      1.) handle rides in the system
             */

             //this is not load data from the database
            $this->view('owners/rides');
        }

        // owner vies the reports and controll
        public function reportsControl(){
            /**
             * Task 
             *      1.) handle reports in the system
             */

            //this is not load data from the data
            $this->view('owners/reports');
        }



    }