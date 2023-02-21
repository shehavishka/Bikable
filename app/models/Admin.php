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

        ////////////////////DASHBOARD////////////////////

        //get first 5 table records of reports
        public function getDashboardReports(){

            $this->db->prepareQuery("SELECT * FROM reports where status = 0 order by loggedTimestamp desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDashboardRepairLog(){

            $this->db->prepareQuery("SELECT * FROM repairlog order by dateIn desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDashboardBicycles(){

            $this->db->prepareQuery("SELECT * FROM bicycles where status = 0 order by datePutInUse desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDashboardRides(){

            $this->db->prepareQuery("SELECT * FROM ridelog where status = 0 order by rideStartTimeStamp desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        ////////////////////QUERIES FOR VIEW ADD UPDATE////////////////////

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

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Mechanic' AND status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRiderDetails(){

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Rider' AND status != 3");

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

        public function updateBikeOwner($data){
            
            $bikeOwnerID = $data['bikeOwnerID'];
            $unic = $data['nic'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $upNumber = intval($data['pNumber']); //should be int
            $uemail = $data['email'];
            
            $temp = "UPDATE bikeowners SET NIC = '$unic', firstName = '$fName', lastName = '$lName', phoneNumber = '$upNumber', emailAdd = '$uemail' WHERE bikeOwnerID = '$bikeOwnerID'";
            $this->db->prepareQuery($temp);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getbikeOwnerDetails(){
            
            $this->db->prepareQuery("SELECT * FROM bikeowners WHERE status != 3");
            
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function addDAIntoTheSystem($data){

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
        }

        public function updateDA($data){
            
            $areaID = intval($data['areaID']); //should be int

            $areaName = $data['areaName'];
            $locationRadius = $data['locationRadius'];
            $status = intval($data['status']); //should be int
            $locationLat = $data['locationLat']; //should be double
            $locationLong = $data['locationLong']; //should be double
            $traditionalAdd = $data['traditionalAdd'];
            $currentNoOfBikes = intval($data['currentNoOfBikes']); //should be int
            
            $temp = "UPDATE dockingareas SET areaName = '$areaName', locationRadius = '$locationRadius', status = '$status', locationLat = '$locationLat', locationLong = '$locationLong', traditionalAdd = '$traditionalAdd', currentNoOfBikes = '$currentNoOfBikes' WHERE areaID = '$areaID'";
            $this->db->prepareQuery($temp);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getDADetails(){

            $this->db->prepareQuery("SELECT * FROM dockingareas where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function addBicycleIntoTheSystem($data){

            $bikeOwnerID = $data['bikeOwnerID'];
            $frameSize = $data['frameSize'];
            $dateAcquired = $data['dateAcquired'];
            $datePutInUse = $data['datePutInUse'];
            $status = intval($data['status']); //should be int
            $currentDA = $data['currentDA'];


            $temp = "INSERT INTO bicycles (bikeOwnerID, frameSize, dateAcquired, datePutInUse, status, currentDA ) VALUES ('$bikeOwnerID', '$frameSize', '$dateAcquired', '$datePutInUse', '$status', '$currentDA')";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function updateBicycle($data){
            
            // $bicycleID = $data['bicycleDetailObject']->bicycleID;
            $bicycleID = $data['bicycleID'];
            $bikeOwnerID = $data['bikeOwnerID'];
            $frameSize = $data['frameSize'];
            $dateAcquired = $data['dateAcquired'];
            $datePutInUse = $data['datePutInUse'];
            $status = intval($data['status']); //should be int
            $currentDA = $data['currentDA'];
            
            $temp = "UPDATE bicycles SET bikeOwnerID = '$bikeOwnerID', frameSize = '$frameSize', dateAcquired = '$dateAcquired', datePutInUse = '$datePutInUse', status = '$status', currentDA = '$currentDA' WHERE bicycleID = '$bicycleID'";
            $this->db->prepareQuery($temp);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getBikeDetails(){

            $this->db->prepareQuery("SELECT * FROM bicycles where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRepairLogDetails(){

            $this->db->prepareQuery("SELECT * FROM repairLog WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getReportDetails(){

            $this->db->prepareQuery("SELECT * FROM reports WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getArchivedRepairLogDetails(){

            $this->db->prepareQuery("SELECT * FROM repairLog WHERE status = 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getArchivedReportDetails(){

            $this->db->prepareQuery("SELECT * FROM reports WHERE status = 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function assignReportMechanic($data){
            
            // $bicycleID = $data['bicycleDetailObject']->bicycleID;
            $reportID = $data['reportID'];
            $mechanicID = $data['mechanicID'];
            
            $temp = "UPDATE reports SET assignedMechanic = '$mechanicID' WHERE reportID = '$reportID'";
            $this->db->prepareQuery($temp);

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getRideDetails(){

            $this->db->prepareQuery("SELECT * FROM ridelog");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }


        ////////////////////QUERIES FOR VIEW BY ID////////////////////

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

        public function findBikeOwnerByID($bikeOwnerID){

            $this->db->prepareQuery("SELECT * FROM bikeowners where bikeOwnerID = '$bikeOwnerID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

        public function findBicycleByID($bicycleID){

            $this->db->prepareQuery("SELECT * FROM bicycles where bicycleID = '$bicycleID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

        public function findAreaByID($areaID){

            $this->db->prepareQuery("SELECT * FROM dockingareas where areaID = '$areaID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

        public function findLogbyID($logID){

            $this->db->prepareQuery("SELECT * FROM repairlog where logID = '$logID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

        public function findReportbyID($reportID){

            $this->db->prepareQuery("SELECT * FROM reports where reportID = '$reportID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }


        ////////////////////QUERIES FOR SUSPEND/ACTIVATE (UPDATE)////////////////////

        public function suspendUserByUserID($userID){
            $status = 1;
            $this->db->prepareQuery("UPDATE users SET status = '$status' WHERE userID = '$userID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function activateUserByUserID($userID){
            $status = 0;
            $this->db->prepareQuery("UPDATE users SET status = '$status' WHERE userID = '$userID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
        
        
        ////////////////////QUERIES FOR REMOVE ARCHIVE UNARCHIVE (TECHNICALLY UPDATE)////////////////////
        
        public function removeUser($userID){
            $status = 3;
            $this->db->prepareQuery("UPDATE users SET status='$status' WHERE userID = '$userID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
        
        public function removeBikeOwner($bikeOwnerID){
            $status = 3;
            $this->db->prepareQuery("UPDATE bikeowners SET status='$status' WHERE bikeOwnerID = '$bikeOwnerID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function removeDA($areaID){
            $status = 3;
            $this->db->prepareQuery("UPDATE dockingareas SET status='$status' WHERE areaID = '$areaID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function removeBicycle($bicycleID){
            $status = 3;
            $this->db->prepareQuery("UPDATE bicycles SET status='$status' WHERE bicycleID = '$bicycleID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function removeReport($reportID){
            $status = 3;
            $this->db->prepareQuery("UPDATE reports SET status='$status' WHERE reportID = '$reportID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function removeRepairLog($logID){
            $status = 3;
            $this->db->prepareQuery("UPDATE repairlog SET status='$status' WHERE logID = '$logID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function unarchiveReport($reportID){
            $status = 0;
            $this->db->prepareQuery("UPDATE reports SET status='$status' WHERE reportID = '$reportID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function unarchiveRepairLog($logID){
            $status = 0;
            $this->db->prepareQuery("UPDATE repairlog SET status='$status' WHERE logID = '$logID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
    }