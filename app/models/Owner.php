<?php 
    class Owner {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        /**
         *      To Add User Into the system need to check validation So, to do that implement some features.    
         * 
        */

        public function findUserByEmail($userEmail){
            $this->db->prepareQuery("SELECT * FROM users where emailAdd = '$userEmail'");
            // $this->db->bind(':email', $userEmail);

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        //find NIC number in the database
        public function findNicNumber($userNIC){
            $this->db->prepareQuery("SELECT * FROM users where NIC = '$userNIC'");

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        //find phone number in the database
        public function findPhoneNumber($userPNumber){
            $this->db->prepareQuery("SELECT * FROM users where phoneNumber = '$userPNumber'");

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }          
        }

        //add user into the system
        public function addUserIntoTheSystem($data){

            $unic = $data['nic'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $upNumber = intval($data['pNumber']); //should be int
            $urole = $data['userRole'];
            $ustatus = intval($data['status']); // should be int
            $uPassword = $data['userPassword'];
            $uemail = $data['email'];

            $temp = "INSERT INTO users (NIC, firstName, lastName, phoneNumber, role, status, password, emailAdd ) VALUES ('$unic', '$fName', '$lName', '$upNumber', '$urole', '$ustatus', '$uPassword', '$uemail')";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////   GET MECHANIC / ADMINISTRATORS / RIDERS / BICYCLE OWNERS /////////////////////////
        ////////////////////////        data from the database /////////////////////////////////////////////////////

        public function getAdminDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'administrator'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getMechanicDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'mechanic'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRiderDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'rider'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getbikeOwnerDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'bikeOwner'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }


        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////   OWNER LANDPAGE MAP PART DATA TAKE FROM THE DATABASE //////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function ownerLandPageMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////// FIND USER BY ID //////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function findUserByUserID($userID){

            $this->db->prepareQuery("SELECT * FROM users where userID = '$userID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

    }