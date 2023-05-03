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
            $timeStamp = $data['timeStamp'];
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

        public function getLastInsertedRideLogID(){
            //use last insert id sql feature
            $lastInsertedId = $this->db->lastInsertId();
            return $lastInsertedId;
        }

        public function getRideDetails($rideID){
            $this->db->prepareQuery("SELECT * FROM ridelog WHERE rideLogID = $rideID");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }

        //needs modification to check for the ride status and stuff.. currently invalid
        // public function getCurrentRideDetails($userID){
        //     $this->db->prepareQuery("SELECT * FROM ridelog WHERE riderID = $userID AND rideEndTimeStamp IS NULL AND status = 1");

        //     // take data from the database as the objects and send them into the controller.
        //     return $this->db->single();
        // }

        //end ride function -> we just change the status to 2 to show the ride is over
        public function updateRideDetails($data){
            $rideLogID = intval($data['rideLogID']); //should be int
            $timeStamp = $data['timeStamp'];
            $endArea = intval($data['endArea']); //should be int
            $fare = floatval($data['fare']); //should be float
            $timeTravelled = intval($data['time_spent']); //should be int
            $status = 2;

            // $temp = "UPDATE ridelog SET (status, endAreaID, rideEndTimeStamp, fare, timeTravelled) VALUES ($status, $endArea, '$timeStamp', $fare, $timeTravelled) WHERE rideLogID = $rideLogID";
            $temp = "UPDATE ridelog SET status = $status, endAreaID = $endArea, rideEndTimeStamp = '$timeStamp', fare = $fare, timeTravelled = $timeTravelled WHERE rideLogID = $rideLogID";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function checkRideStatus($rideLogID){
            $this->db->prepareQuery("SELECT status FROM ridelog WHERE rideLogID = $rideLogID");

            // take data from the database as the objects and send them into the controller.
            if($this->db->single()){
                return $this->db->single();
            }else{
                die("Error in checkRideStatus function in Rider model");
            }
        }

        public function checkIfActive($riderID){
            $this->db->prepareQuery("SELECT rideLogID FROM ridelog WHERE riderID = $riderID AND status = 1");

            $this->db->single();

            if($this->db->rowCount() == 0){
                return false;
            }else if($this->db->rowCount() == 1){
                return $this->db->single();
            }else{
                die("Error in checkIfActive function in Rider model");
            }
        }

        public function updateBikeStatus($bikeID, $status){
            //fetch the bike's status and if it's not equal to $status, update it to status = $status and return true
            //if it is equal to $status, return false
            $this->db->prepareQuery("SELECT status FROM bicycles WHERE bicycleID = $bikeID");

            $this->db->single();

            if($this->db->single()->status == $status){
                return false;
            }else{
                $this->db->prepareQuery("UPDATE bicycles SET status = $status WHERE bicycleID = $bikeID");

                if($this->db->executeStmt()){
                    return true;
                }else{
                    return false;
                }
            }
        }

        public function updateDockingAreaBikeCount($areaID, $action){
            if($action == 1){
                $temp = "UPDATE dockingareas SET currentNoOfBikes = currentNoOfBikes + 1 WHERE areaID = $areaID";
            }else if($action == 2){
                $temp = "UPDATE dockingareas SET currentNoOfBikes = currentNoOfBikes - 1 WHERE areaID = $areaID";
            }else{
                die("Error in updateDockingAreaBikeCount function in Rider model");
            }

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }
        
    }