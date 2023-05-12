<?php 
    class Mechanic {
        private $db;

        public function __construct(){
            $this->db = new Database;
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

                


        public function editReport($data){
            $reportID = $data['reportID'];
            $reporterID = $_SESSION['reporterID'];
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
            $this->db->prepareQuery("SELECT * FROM dockingareas WHERE status !=3");
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