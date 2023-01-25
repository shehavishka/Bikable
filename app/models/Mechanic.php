<?php 
    class Mechanic {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function addReport($data){
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

            $this->db -> prepareQuery("INSERT INTO reports (Report_ID, Repair_Log_ID, Bicycle_ID, Problem_Title, Date_IN, Mechanic_ID, Solution_Description, Tag) VALUES ('$Rid', '$RLid', '$Bid', '$Ptitle', '$Din',  '$Mid', '$SolnDesc', '$Tag')");

            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }

        }

        // get mechanic details
        public function getReports(){
            $this->db->prepareQuery("SELECT * FROM reports");

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
        // public function findUserByEmail($userEmail){
        //     $this->db->prepareQuery("SELECT * FROM repairlog where email = '$userEmail'");
        //     // $this->db->bind(':email', $userEmail);

        //     $this->db->single();

        //     //check row
        //     if($this->db->rowCount() > 0){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }
    }