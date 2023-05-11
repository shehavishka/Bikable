<?php 
    // Rider model class 23-05-11
    // 1. riderLandPageMapDetails()
    // 2. getAllMapDetails()
    // 3. getDADetails($id)
    // 4. getBikeDetails()
    // 5. createRide($data)
    // 6. getLastInsertedRideLogID()
    // 7. getRideDetails($rideID)
    // 8. updateRideDetails($data)
    // 9. checkRideStatus($rideLogID)
    // 10. checkIfActive($riderID)
    // 11. updateBikeStatus($bikeID, $status)
    // 12. updateDockingAreaBikeCount($areaID, $action)
    // 13. getUserDetails($userID)
    // 14. updateUserDetails($data)
    // 15. getRideHistory()
    // 16. getReportsDetails()
    // 17. getReportByID()
    // 18. updateReport()
    // 19. deleteReport()
    // 20. checkPassword()
    // 21. changePassword()
    // 22. deleteUser()
    // 23. findUserByEmail()
    // 24. findNicNumber()
    // 25. findPhoneNumber()

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

        public function getAllMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas");

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
        
        public function getUserDetails($userID){
            $this->db->prepareQuery("SELECT * FROM users WHERE userID = $userID");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }

        public function updateUserDetails($data){
            $userID = $_SESSION['user_ID'];
            $fName = $data['fName'];
            $lName = $data['lName'];
            $email = $data['email'];
            $phone = $data['phone'];
            $nic = $data['NIC'];

            $temp = "UPDATE users SET firstName = '$fName', lastName = '$lName', emailAdd = '$email', phoneNumber = '$phone', NIC = '$nic' WHERE userID = $userID";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                // update session variables
                $_SESSION['user_NIC'] = $nic;
                $_SESSION['user_fName'] = $fName;
                $_SESSION['user_lName'] = $lName;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_pNumber'] = $phone;

                return true;
            }else{
                return false;
            }
        }

        public function getRideHistory($userID){
            $this->db->prepareQuery("SELECT * FROM ridelog WHERE riderID = $userID AND status = 2 ORDER BY rideLogID DESC");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getReportsDetails($userID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE reporterID = $userID AND status != 3 ORDER BY reportID DESC");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function createReport($data){
            $reporterID = $_SESSION['user_ID'];
            $type = $data['type'];
            $problemTitle = $data['problemTitle'];
            $problemDescription = $data['problemDescription'];
            $areaID = $data['areaID'];
            $accidentLocation = $data['accidentLocation'];
            $timeStamp = $data['accidentTimeStamp'];
            $bicycleID = $data['bicycleID'];
            // $image = $data['image'];
            $status = 0;

            // $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, areaID, accidentLocation, accidentTimeApprox, bicycleID, image, status) VALUES ($reporterID, $type, '$problemTitle', '$problemDescription', $areaID, '$accidentLocation', '$timeStamp', $bicycleID, '$image', $status)";
            if($type == "Accident"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, accidentLocation, accidentTimeApprox, bicycleID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', '$accidentLocation', '$timeStamp', $bicycleID, $status)";
            }else if($type == "Bicycle"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, bicycleID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', $bicycleID, $status)";
            }else if($type == "Area"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, areaID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', $areaID, $status)";
            }else if($type == "Other"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', $status)";
            }
                
            print_r($temp);

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function getReportByID($reportID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE reportID = $reportID");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }

        public function updateReport($data){
            $reportID = $data['reportID'];
            $reporterID = $_SESSION['user_ID'];
            $type = $data['type'];
            $problemTitle = $data['problemTitle'];
            $problemDescription = $data['problemDescription'];
            $areaID = $data['areaID'];
            $accidentLocation = $data['accidentLocation'];
            $timeStamp = $data['accidentTimeStamp'];
            $bicycleID = $data['bicycleID'];
            // $image = $data['image'];
            $status = 0;

            // $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, areaID, accidentLocation, accidentTimeApprox, bicycleID, image, status) VALUES ($reporterID, $type, '$problemTitle', '$problemDescription', $areaID, '$accidentLocation', '$timeStamp', $bicycleID, '$image', $status)";
            if($type == "Accident"){
                $temp = "UPDATE reports SET reportType = '$type', problemTitle = '$problemTitle', problemDescription = '$problemDescription', accidentLocation = '$accidentLocation', accidentTimeApprox = '$timeStamp', bicycleID = $bicycleID, status = $status WHERE reportID = $reportID";
            }else if($type == "Bicycle"){
                $temp = "UPDATE reports SET reportType = '$type', problemTitle = '$problemTitle', problemDescription = '$problemDescription', bicycleID = $bicycleID, status = $status WHERE reportID = $reportID";
            }else if($type == "Area"){
                $temp = "UPDATE reports SET reportType = '$type', problemTitle = '$problemTitle', problemDescription = '$problemDescription', areaID = $areaID, status = $status WHERE reportID = $reportID";
            }else if($type == "Other"){
                $temp = "UPDATE reports SET reportType = '$type', problemTitle = '$problemTitle', problemDescription = '$problemDescription', status = $status WHERE reportID = $reportID";
            }

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        //it's actually a soft delete - we make the status 3
        public function deleteReport($reportID){
            $temp = "UPDATE reports SET status = 3 WHERE reportID = $reportID";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function checkPassword($password){
            // die("model reached");   
            $userID = $_SESSION['user_ID'];
            $this->db->prepareQuery("SELECT * FROM users WHERE userID = $userID");

            $row = $this->db->single();

            // we need to hash passwords
            $temp = $row->password;
            if($password == $temp){
                return true;
            }else{
                return false;
            }
        }

        public function changePassword(){
            $userID = $_SESSION['user_ID'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if($newPassword == $confirmPassword){
                $temp = "UPDATE users SET password = '$newPassword' WHERE userID = $userID";
                $this->db->prepareQuery($temp);

                if($this->db->executeStmt()){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function deleteUser($userID){
            $temp = "UPDATE users SET status = 3 WHERE userID = $userID";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        //////////////////////////// validation for user update ////////////////////////////

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
    }