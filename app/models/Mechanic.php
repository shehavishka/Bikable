<?php 
    class Mechanic {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }
         
        public function addLogIntoTheSystem(){
            $reportID = $_POST['reportID'];
            $estCost = $_POST['estCost'];
            $problemTitle = $_POST['problemTitle'];
            // $problemDescription = $_POST['problemDescription'];
            $dateIn = $_POST['dateIn'];
            $dateOut = $_POST['dateOut'];
            $finalCost = $_POST['finalCost'];
            $bicycleID = $_POST['bicycleID'];
            $mechanicID = $_SESSION['user_ID'];
            $status = 0;
            $repairNotes = $_POST['repairNotes'];

            $temp = "INSERT INTO repairlog (reportID, problemTitle, estCost, finalCost, dateIn, dateOut, bicycleID, mechanicID, status, repairNotes) VALUES ('$reportID', '$problemTitle', '$estCost', '$finalCost', '$dateIn', '$dateOut', '$bicycleID','$mechanicID', '$status', '$repairNotes')";
            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
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

        
        public function addReportIntoTheSystem($data){
            // die('Inserted');
            $reporterID = $_SESSION['user_ID'];
            $type = $data['type'];
            $problemTitle = $data['problemTitle'];
            $problemDescription = $data['problemDescription'];
            $areaID = $data['areaID'];
            $accidentLocation = $data['accidentLocation'];
            $timeStamp = $data['accidentTimeStamp'];
            $bicycleID = $data['bicycleID'];
            $mechanicID = $_SESSION['user_ID'];
            // $image = $data['image'];
            $status = 0;

            // $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, areaID, accidentLocation, accidentTimeApprox, bicycleID, image, status) VALUES ($reporterID, $type, '$problemTitle', '$problemDescription', $areaID, '$accidentLocation', '$timeStamp', $bicycleID, '$image', $status)";
            if($type == "Accident"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, assignedMechanic, accidentLocation, accidentTimeApprox, bicycleID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', '$mechanicID', '$accidentLocation', '$timeStamp', $bicycleID, $status)";
            }else if($type == "Bicycle"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, assignedMechanic, bicycleID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription','$mechanicID', $bicycleID, $status)";
            }else if($type == "Area"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, assignedMechanic, areaID, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription','$mechanicID', $areaID, $status)";
            }else if($type == "Other"){
                $temp = "INSERT INTO reports (reporterID, reportType, problemTitle, problemDescription, assignedMechanic, status) VALUES ($reporterID, '$type', '$problemTitle', '$problemDescription', '$mechanicID', $status)";
            }
                
            print_r($temp);

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        // public function viewReport($data){
        //     // die('Inserted');
        //     $reporterID = $data['reporterID'];
        //     $type = $data['type'];
        //     $problemTitle = $data['problemTitle'];
        //     $problemDescription = $data['problemDescription'];
        //     $areaID = $data['areaID'];
        //     $accidentLocation = $data['accidentLocation'];
        //     $timeStamp = $data['accidentTimeStamp'];
        //     $bicycleID = $data['bicycleID'];
        //     $mechanicID = $_SESSION['user_ID'];
        //     // $image = $data['image'];
        //     $status = 0;

        //     $temp = "SELECT * reports 
                           
        //     print_r($temp);

        //     $this->db->prepareQuery($temp);

        //     if($this->db->executeStmt()){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }       
        
        

        public function editRepairLog($data){
            $repairLogID = $data['repairLogID'];
            $reportID = $data['reportID'];
            $estCost = $data['estCost'];
            $problemTitle = $data['problemTitle'];
            $problemDescription = $data['problemDescription'];
            $areaID = $data['areaID'];
            $dateIn = $data['dateIn'];
            $dateOut = $data['dateOut'];
            $finalCost = $data['finalCost'];
            $bicycleID = $data['bicycleID'];
            $repairNotes = $data['repairNotes'];
            

            $temp = "UPDATE repairLogs SET areaID = '$areaID' problemDescription = '$problemDescription', estCost = '$estCost', finalCost = '$finalCost', dateIn = '$dateIn', dateOut ='$dateOut', repairNotes ='$repairNotes' WHERE repairLogID = $repairLogID";
            

            $this->db->prepareQuery($temp);

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function mechanicLandPageMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function addLog($data){
            //die('Inserted')
            $RLid = $data['RLid'];
            $Bid = $data['Bid'];
            $Ptitle = $data['Ptitle'];
            $Din = $data['Din'];
            $Tin = $data['Tin'];
            $Mid = $data['Mid'];
            $ProbDesc = $data['ProbDesc'];
            $RepDesc = $data['RepDesc'];
            $EstCost = $data['EstCost'];
            $Dout = $data['Dout'];
            $FinCost = $data['FinCost'];

            $this->db -> prepareQuery("INSERT INTO Repair_Logs(Repair_Log_ID, Bicycle_ID, Problem_Title, Date_IN, Time_IN, Mechanic_ID, Problem _Description, Report_Description, Estimated_Cost, Date_OUT, Final_Cost) VALUES ('$RLid', '$Bid', '$Ptitle', '$Din', '$Tin', '$Mid', '$ProbDesc', '$RepDesc', '$EstCost', '$Dout', '$FinCost')");

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }


        public function getDashboardRepairLog(){

            $this->db->prepareQuery("SELECT * FROM repairlog order by dateIn desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRepairLogDetails(){
            $this->db->prepareQuery("SELECT * FROM repairlog WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getDashboardReports(){

            $this->db->prepareQuery("SELECT * FROM reports where status = 0 order by loggedTimestamp desc limit 6");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getRepairLogsDetails()
        {
            $this->db->prepareQuery("SELECT * FROM repairlog WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getReportDetails(){
            $this->db->prepareQuery("SELECT * FROM reports WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function findLogByID($LogID){
            $this->db->prepareQuery("SELECT * FROM repairlog WHERE logID = '$LogID'");

            $row = $this->db->single();

            //check
            if($this->db->rowCount()>0){
                return $row;
            }else{
                return false;
            }
        }

        public function getReportByUserID($mechanicID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE assignedMechanic = '$mechanicID'");

            //takes data from the database and sends them to the controller
            return $this->db->resultSet();
        }

        public function getReportByID($reportID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE reportID = $reportID");

            // take data from the database as the objects and send them into the controller.
            return $this->db->single();
        }
        
        public function getAllMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function findReportByID($reportID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE reportID = '$reportID'");

            $row = $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return $row;
            }else{
                return false;
            }
        }

        public function getDADetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas where status !=3");

            //Takes data from the database and send them to the controller
            return $this->db->resultSet();
        }

        public function getAllDADetails(){

            $this->db->prepareQuery("SELECT * FROM dockingareas where status = 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getArchivedRepairLogDetails(){

            $this->db->prepareQuery("SELECT * FROM repairLog WHERE status = 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getMechanicDetails(){
            $this->db->prepareQuery("SELECT * FROM users WHERE role = 'Mechanic' AND status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function findAreaByID($areaID){

            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE areaID = '$areaID'");

            $row = $this -> db -> single();

            if($this->db->rowcount() > 0){
                return $row;
            }else{
                return false;
            }
        }
        
        public function getDashboardDA(){
            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE status = 0");
            return $this->db->resultSet();
        }

        public function getDashboardBicycles(){
            $this->db->prepareQuery("SELECT * FROM bicycles WHERE status = 0 order by datePutInUse desc limit 6");
            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getBicycleDetails(){
            $this->db->prepareQuery("SELECT * FROM bicycles where status != 3");

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

        //Mobile views
        public function mechanicMobLandPageMapDetails(){
            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
        }

        public function getBikeDetails(){

            $this->db->prepareQuery("SELECT * FROM bicycles WHERE status != 3");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
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

        public function getReportsDetails($userID){
            $this->db->prepareQuery("SELECT * FROM reports WHERE reporterID = $userID AND status != 3 ORDER BY reportID DESC");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
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

        public function getRepairLogMobDetails($userID){
            $this->db->prepareQuery("SELECT * FROM repairlog WHERE reporterID = $userID AND status != 3 ORDER BY logID DESC");

            // take data from the database as the objects and send them into the controller.
            return $this->db->resultSet();
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

        


    }