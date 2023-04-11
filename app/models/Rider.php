<?php 
    class Rider {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function riderLandPageMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDADetails($id){
            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE areaID = $id");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }

        public function getBikeDetails(){

            $this->db->prepareQuery("SELECT * FROM bicycles WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function createRide($data){
            $userID = intval($data['userID']); //should be int
            $bicycleID = intval($data['bicycleID']); //should be int
            $timeStamp = $data['timeStamp']; //should be int
            $startArea = intval($data['startArea']); //should be int
            $payMethod = intval($data['payMethod']); //should be int
            $status = 1;

            $temp = "INSERT INTO ridelog (riderID, bicycleID, status, startAreaID, rideStartTimeStamp, payMethod) VALUES ($userID, $bicycleID, $status, $startArea, '$timeStamp', $payMethod)";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function getRideDetails($rideID){
            $this->db->prepareQuery("SELECT * FROM ridelog WHERE rideID = $rideID");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }

        public function getCurrentRideDetails($userID){
            $this->db->prepareQuery("SELECT * FROM ridelog WHERE riderID = $userID AND rideEndTimeStamp IS NULL");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }
        
    }