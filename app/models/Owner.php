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

        public function getRidesDetails(){
                
            $this->db->prepareQuery("SELECT * FROM ridelog");
    
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getBicyclesDetails(){

            $this->db->prepareQuery("SELECT * FROM bicycles");
            
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDockingAreasDetails(){

            $this->db->prepareQuery("SELECT * FROM dockingareas where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getReportDetails(){

            $this->db->prepareQuery("SELECT * FROM reports");
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

        /////////////////////////////////////////////////////////////////////////////////////////////////////////

        public function suspendUserByUserID($userID){
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

        public function activateUserByUserID($userID){
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

        /////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////   OWNER UPDATE HIS DATA IN THE DATA BASE //////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        public function ownerUpdatesHisData($data){

            $unic = $data['nic'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $uemail = $data['email'];
            $userID = $_SESSION['user_ID'];

            
            // $temp = "INSERT INTO users (NIC, firstName, lastName, phoneNumber, role, status, password, emailAdd ) VALUES ('$unic', '$fName', '$lName', '$upNumber', '$urole', '$ustatus', '$uPassword', '$uemail')";
            $temp = "UPDATE users SET firstName = '$fName', lastName = '$lName', emailAdd = '$uemail', NIC = '$unic' WHERE userID = '$userID' ";


            
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////   OWNER CHANGES HIS PASSWORD  /////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////

        public function ownerChangesHisPassword($data){
            $newPassword = $data['newPassword'];
            //hash the password
            $hashedPassword = password_hash(strval($newPassword), PASSWORD_DEFAULT);
            $userEmail = $_SESSION['user_email'];

            //prepare query
            $temp = "UPDATE users SET password = '$hashedPassword' WHERE emailAdd = '$userEmail' ";

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Owner upload his profile picture
        public function ownerUploadsHisProfilePicture($data){
            $profilePicture = $data;
            $userEmail = $_SESSION['user_email'];
            //prepare query
            $temp = "UPDATE users SET userPicture = '$profilePicture' WHERE emailAdd = '$userEmail' ";

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Owner land page reports (reportID, assignedMechanic) get from the database
        public function ownerLandpageReportIDAssignedMechanic(){
            $this->db->prepareQuery("SELECT reportID , assignedMechanic FROM reports");
            

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Owner land page repair log (logID, bicycleID, dateIn) get from the database
        public function ownerLandpageRepairLogDetails(){
            $this->db->prepareQuery("SELECT logID , bicycleID , dateIn FROM repairlog order by dateIn desc limit 6");
            

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Owner land page bicycles (bicycleID, frameSize, status) get from the database
        public function ownerLandpageBicyclesDetails(){
            $this->db->prepareQuery("SELECT bicycleID , frameSize , status FROM bicycles");
            

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Statis page data get from the database

        //get total number of riders
        public function getTotalRiders(){
            $this->db->prepareQuery("SELECT COUNT(*) FROM users WHERE role = 'rider' ");

            $row = $this->db->single();
            return $row;
        }

        //get total number of bicycles
        public function getTotalBicycles(){
            $this->db->prepareQuery("SELECT COUNT(*) FROM bicycles");

            $row = $this->db->single();
            return $row;
        }

        public function getTotalDockingAreas(){
            $this->db->prepareQuery("SELECT COUNT(*) FROM dockingareas");

            $row = $this->db->single();
            return $row;
        }

        public function getActiveReports(){
            $this->db->prepareQuery("SELECT COUNT(*) FROM reports WHERE status = 0 ");

            $row = $this->db->single();
            return $row;
        }

        public function getFareAndRate(){
            $this->db->prepareQuery("SELECT baseValue, ratePer10 FROM fareRate ORDER BY timeStamp DESC LIMIT 1");

            $row = $this->db->single();
            return $row;
        }

        public function setFareAndRate($data){

            $baseValue = $data['fareValue'];
            $ratePer10 = $data['rateValue'];

            $userID = $_SESSION['user_ID'];
            $temp = "INSERT INTO fareRate (userID, baseValue, ratePer10) VALUES ('$userID', '$baseValue', '$ratePer10')";

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }

        }

        public function search_adminstrators($search){

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Administrator' AND (firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR emailAdd LIKE '%$search%' OR NIC LIKE '%$search%')");

            return $this->db->resultSet();
        }

    }
