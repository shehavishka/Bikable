<?php 
    class Admin {
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

        //find bike owner email in the database
        public function findBOByEmail($userEmail){
            $this->db->prepareQuery("SELECT * FROM bikeowners where emailAdd = '$userEmail'");
            // $this->db->bind(':email', $userEmail);

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        //find bike owner NIC number in the database
        public function findBONicNumber($userNIC){
            $this->db->prepareQuery("SELECT * FROM bikeowners where NIC = '$userNIC'");

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        //find bike owner phone number in the database
        public function findBOPhoneNumber($userPNumber){
            $this->db->prepareQuery("SELECT * FROM bikeowners where phoneNumber = '$userPNumber'");

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
        
        public function getMechanicDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'Mechanic'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRiderDetails(){

            $this->db->prepareQuery("SELECT * FROM users where role = 'Rider'");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }
        
        public function addBikeOwnerIntoTheSystem($data){

            $unic = $data['nic'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $upNumber = intval($data['pNumber']); //should be int
            $uemail = $data['email'];

            $temp = "INSERT INTO bikeowners (NIC, firstName, lastName, phoneNumber, emailAdd ) VALUES ('$unic', '$fName', '$lName', '$upNumber', '$uemail')";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function getbikeOwnerDetails(){
            
            $this->db->prepareQuery("SELECT * FROM bikeowners");
            
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function addDAIntoTheSystem($data){

            // $unic = $data['nic'];
            // $fName = $data['fName'];
            // $lName = $data['lName'];
            // $upNumber = intval($data['pNumber']); //should be int
            // $uemail = $data['email'];

            $areaName = $data['areaName'];
            $locationRadius = $data['locationRadius'];
            $status = intval($data['status']); //should be int
            $locationLat = $data['locationLat']; //should be double
            $locationLong = $data['locationLong']; //should be double
            $traditionalAdd = $data['traditionalAdd'];
            $currentNoOfBikes = intval($data['currentNoOfBikes']); //should be int

            $temp = "INSERT INTO dockingareas (areaName, locationRadius, status, locationLat, locationLong, traditionalAdd, currentNoOfBikes ) VALUES ('$areaName', '$locationRadius', '$status', '$locationLat', '$locationLong', '$traditionalAdd', '$currentNoOfBikes')";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }

            // $temp = "INSERT INTO bikeowners (NIC, firstName, lastName, phoneNumber, emailAdd ) VALUES ('$unic', '$fName', '$lName', '$upNumber', '$uemail')";
            // $this->db->prepareQuery($temp);

            // if($this->db->executeStmt()){
            //     return true;
            // }else{
            //     return false;
            // }
        }

        public function getDADetails(){

            $this->db->prepareQuery("SELECT * FROM dockingareas where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getBikeDetails(){

            $this->db->prepareQuery("SELECT * FROM bicycles where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRepairLogDetails(){

            $this->db->prepareQuery("SELECT * FROM repairLog");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getReportDetails(){

            $this->db->prepareQuery("SELECT * FROM reports");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }
    }