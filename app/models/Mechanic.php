<?php 
    class Mechanic {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }
         
        public function addReportIntoTheSystem($data){
            // die('Inserted');
            $Rid = $data['Rid'];
            $RLid = $data['RLid'];
            $Bid = $data['Bid'];
            $Ptitle = $data['Ptitle'];
            $Din = $data['Din'];
            $Tin = $data['Tin'];
            $Mid = $data['Mid'];
            $SolnDesc = $data['SolnDesc'];
            $Tag = $data['Tag'];

            $this->db->prepareQuery("INSERT INTO reports(Report_ID, Repair_Log_ID, Bicycle_ID, Problem_Title, Date_IN, Mechanic_ID, Solution_Description, Tag) VALUES ('$Rid', '$RLid', '$Bid', '$Ptitle', '$Din',  '$Mid', '$SolnDesc', '$Tag')");

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


    }