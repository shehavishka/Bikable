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

        //add user into the system
        public function addUserIntoTheSystem($data){

            $unic = $data['nic'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $upNumber = $data['pNumber'];
            $urole = $data['userRole'];
            $ustatus = $data['status'];
            $uPassword = $data['userPassword'];
            $uemail = $data['email'];


            $this->db->prepareQuery("INSERT INTO users ( NIC, firstName, lastName, phoneNumber, role, status, password, emailAdd ) VALUES ('$unic', '$fName', '$lName', '$upNumber', '$urole', '$ustatus', '$uPassword', '$uemail')");
            
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

        public function getDADetails(){

            $this->db->prepareQuery("SELECT * FROM dockingareas where status = 0");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }
    }