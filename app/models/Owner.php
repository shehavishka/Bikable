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

            // $this->db->prepareQuery("SELECT * FROM bicycles");
            $this->db->prepareQuery("SELECT * FROM bicycles where status != 3");
            
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
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

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // update bicycle
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

        public function getDockingAreasDetails(){

            // get Active and Inactive docking areas
            $this->db->prepareQuery("SELECT * FROM dockingareas where status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Add docking area to the system
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

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // Delete docking Areas
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

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // find area by ID
        public function findAreaByID($areaID){
            
            $this->db->prepareQuery(" SELECT * FROM dockingareas where areaID = '$areaID' ");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            } 
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // update docking area
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

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // add bicycle to the system
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

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // delete bike selected
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


        public function getReportDetails(){

            // $this->db->prepareQuery("SELECT * FROM reports");
            $this->db->prepareQuery("SELECT * FROM reports WHERE status != 3");

            return $this->db->resultSet();
        }

        public function getArchivedReportDetails(){

            $this->db->prepareQuery("SELECT * FROM reports WHERE status = 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
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

        ////////////////////////////////////////////////////////////////////////////////////////////////////////
        // SEARCH FUNCTIONS

        public function search_adminstrators($search){

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Administrator' AND (firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR emailAdd LIKE '%$search%' OR NIC LIKE '%$search%')");

            return $this->db->resultSet();
        }

        public function search_mechanics($search){

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Mechanic' AND (firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR emailAdd LIKE '%$search%' OR NIC LIKE '%$search%')");

            return $this->db->resultSet();
        }

        public function search_riders($search){

            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Rider' AND (firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR emailAdd LIKE '%$search%' OR NIC LIKE '%$search%')");

            return $this->db->resultSet();
        }

        public function search_bicycleOwners($search){

            // $this->db->prepareQuery("SELECT * FROM users WHERE (bicycleID LIKE '%$search%' OR frameSize LIKE '%$search%' OR status LIKE '%$search%')");
            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'BikeOwner' AND (firstName LIKE '%$search%' OR lastName LIKE '%$search%' OR emailAdd LIKE '%$search%' OR NIC LIKE '%$search%')");


            return $this->db->resultSet();
        }

        public function search_docking_areas($search){

            // $this->db->prepareQuery("SELECT * FROM dockingareas WHERE (areaID LIKE '%$search%' OR areaName LIKE '%$search%' OR currentNoOfBikes LIKE '%$search%')");
            $this->db->prepareQuery("SELECT * FROM dockingareas
                                    WHERE status <> '3'
                                    AND 
                                    (areaID LIKE '%$search%' OR areaName LIKE '%$search%' OR currentNoOfBikes LIKE '%$search%') ;
            ");
            return $this->db->resultSet();
        }

        public function search_bicycles($search){
                
                $this->db->prepareQuery("SELECT * FROM bicycles
                                         WHERE status <> '3' 
                                         AND (bicycleID LIKE '%$search%' OR frameSize LIKE '%$search%' OR status LIKE '%$search%' OR bikeOwnerID LIKE '%$search%')");
    
                return $this->db->resultSet();
        }


        public function search_rides($search){
                    
                $this->db->prepareQuery("SELECT * FROM ridelog
                                        WHERE (riderID LIKE '%$search%' OR bicycleID LIKE '%$search%')");
                return $this->db->resultSet();
        }

        public function search_reports($search){
                    
                $this->db->prepareQuery("SELECT * FROM reports
                                        WHERE status <> '3'
                                        AND (reportID LIKE '%$search%' OR reporterID LIKE '%$search%' OR problemTitle LIKE '%$search%' OR assignedMechanic LIKE '%$search%')");
                return $this->db->resultSet();
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////
        //  GET BICYCLE STATUS
        public function getBicycleCountByStatus() {
            // Create connection

            $this->db->prepareQuery("SELECT status, COUNT(*) AS count FROM bicycles GROUP BY status ");

            return $this->db->resultSet();
        }

        public function getlatestSevenDays(){
            $this->db->prepareQuery("SELECT DISTINCT DATE(loggedTimestamp) AS date FROM reports
            WHERE loggedTimestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY date DESC
            ");

            return $this->db->resultSet();
        }

        public function bikeReportsCount($date){
            $this->db->prepareQuery("SELECT COUNT(*) AS bicycle_count FROM reports WHERE DATE(loggedTimestamp) = '$date' AND reportType = 'Bicycle' ");

            return $this->db->single();
        }

        public function areaReportsCount($date){
            $this->db->prepareQuery("SELECT COUNT(*) AS area_count FROM reports WHERE DATE(loggedTimestamp) = '$date' AND reportType = 'Area' ");

            return $this->db->single();
        }

        public function accidentReport($date){
            $this->db->prepareQuery("SELECT COUNT(*) AS accident_count FROM reports WHERE DATE(loggedTimestamp) = '$date' AND reportType = 'Accident' ");

            return $this->db->single();
        }
    
    }
