<?php
class Mechanics extends Controller
{   
    // mechanic connects to the database
    private $mechanicModel;


    public function __construct()
    {   
        //connects to the database
        $this->mechanicModel = $this->model('Mechanic');
    }
    
    public function login(){
        //if (session)
        header('location:' . URLROOT . '/users/login');
    }

    public function mechanicLandPage(){
        /**
         *     Tasks
         *          1.) Load the data 
         *          2.) View the data
        *  */ 
    
        //code will implement here
        $repairLogDetails = $this->mechanicModel->getDashboardRepairLog();
        $reportDetails = $this->mechanicModel->getDashboardReports();
        $DADetails = $this->mechanicModel->getDashboardDA();
        $bicycleDetails = $this->mechanicModel->getDashboardBicycles();
        $data = [
            'dashboard_repairLog' => $repairLogDetails,
            'dashboard_reports' => $reportDetails,
            'docking_areas_details' => $DADetails,
            'dashboard_bicycles' => $bicycleDetails
        ];

    //  view details
        $this->view('mechanics/mechanicLandPage', $data);
    }

    public function mechanicMobLandPage(){
        //check if a ride is already active and the user simply refreshed the page
        if($this->redirectIfActive()){
            return;
        }
        
        $map = $this->mechanicModel->mechanicMobLandPageMapDetails();

        $data = [
            //fetch map and all active bike details
            // 'bikeDetails' => $bicycles,
            'mapDetails' => $map
        ];

        //view details
        $this->view('mechanics/mechanicMobLandPage', $data);
    }

    public function repairLogsControl(){
        /**
         * Task 
         *      1.) handle repair in the system
         *      2.) View the data
        **/ 
    
        // load mechanic's repairLog control
        //code will implement here

        // $problemDescription = $this->mechanicModel->getReportByID();
        // $data = ['problem_description' => $problemDescription];

        $repairLogDetails = $this->mechanicModel->getRepairLogDetails();
        $data = [
            'repairLog_details' => $repairLogDetails
        ];

        //this is not load data from the data
        $this->view('mechanics/repairLogs', $data);
    }

    public function AccidentReportsControl(){
        /**
         * Task 
         *      1.) handle repair in the system
         *      2.) View the data
        *  */ 
    
        // load admin's repairlog control
        //code will implement here
        $reportDetails = $this->mechanicModel->getReportDetails();
        $data = [
            'report_details' => $reportDetails,
            'mechanicName_details' => '',
        ];
        $data['mechanicName_details'] = $this->mechanicModel->getMechanicDetails();
        //this is not load data from the data
        $this->view('mechanics/reportsAccident', $data);
    }

    public function viewRepairLog(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'logID' => intval(trim($_GET['logID'])),
                'logDetailObject' => ''
            ];
            $data['logDetailObject'] = $prespectiveUserDetail = $this->mechanicModel->findLogbyID($data['logID']);
            $this->view('mechanics/viewRepairLog', $data);
        }else{
            die("button didn't work correctly.");
        }            
    }

    // public function addLog()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         $data = [
    //             'RLid' => trim($_POST['Repair_Log_ID']),
    //             'Bid' => trim($_POST['BicycleID']),
    //             'Ptitle' => trim($_POST['Problem_Title']),
    //             'Din' => trim($_POST['Date_In']),
    //             'Tin' => trim($_POST['Time_In']),
    //             'Mid' => trim($_POST['Mechanic_ID']),
    //             'ProbDesc' => trim($_POST['Problem_Description']),
    //             'RepDesc' => trim($_POST['Repair_Description']),
    //             'EstCost' => trim($_POST['Estimated_cost']),
    //             'Dout' => trim($_POST['Date_Out']),
    //             'FinCost' => trim($_POST['Final_Cost']),

    //             'RLid_err' => '',
    //             'Bid_err' => '',
    //             'Ptitle_err' => '',
    //             'Din_err' => '',
    //             'Tin_err' => '',
    //             'Mid_err' => '',
    //             'ProbDesc_err' => '',
    //             'RepDecs_err' => '',
    //             'EstCost_err' => '',
    //             'Dout_err' => '',
    //             'FinCost' => '',
    //         ];

    //         $this->mechanicModel->addLog($data);
    //         redirect('mechanics/mechanicLandPage');

    //     } else
    //         $this->view('mechanics/addLog',[
    //             'RLid_err' => '',
    //             'Bid_err' => '',
    //             'Ptitle_err' => '',
    //             'Din_err' => '',
    //             'Tin_err' => '',
    //             'Mid_err' => '',
    //             'ProbDesc_err' => '',
    //             'RepDesc_err' => '',
    //             'EstCost_err' => '',
    //             'Dout_err' => '',
    //             'FinCost' => '',
    //     ]);
    // }

    public function addLog(){
        $data = [
            'reportID' => '',
            'bicycleID' => '',
            'problemTitle' => '',
            'dateIn' => '',
            'dateOut' => '',
            'mechanicID' => '',
            'problemDescription' => '',
            'finalCost' => '',
            'estCost' => '',
            'repairNotes' => '',

            'reportID_err' => '',
            'bicycleID_err' => '',
            'problemTitle_err' => '',
            'dateIn_err' => '',
            'dateOut_err' => '',
            'mechanicID_err' => '',
            // 'problemDescription_err' => '',
            'finalCost_err' => '',
            'estCost_err' => '',
            'repairNotes_err' => ''
        ];
        // $data['reportID'] = $this->mechanicModel->getReportByID();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'reportID' => trim($_POST['reportID']),
                'bicycleID' => trim($_POST['bicycleID']),
                'problemTitle' => trim($_POST['problemTitle']),
                'dateIn' => trim($_POST['dateIn']),
                'dateOut' => trim($_POST['dateOut']),
                'mechanicID' => trim($_POST['mechanicID']),
                // 'problemDescription' => trim($_POST['problemDescription']),
                'finalCost' => trim($_POST['finalCost']),
                'estCost' => trim($_POST['estCost']),
                'repairNotes' => trim($_POST['repairNotes']),

                'reportID_err' => '',
                'bicycleID_err' => '',
                'problemTitle_err' => '',
                'dateIn_err' => '',
                'dateOut_err' => '',
                'mechanicID_err' => '',
                // 'problemDescription_err' => '',
                'finalCost_err' => '',
                'estCost_err' => '',
                'repairNotes_err' => ''
            ];
            if(empty($data['reportID'])){
                $data['reportID_err'] = 'Please enter report ID';
            }
            // if (empty($data['dateIn'])) {
            //     $data['dateIn_err'] = '*Please select a date';
            //     // else if date is after today
            // } else if ($data['dateIn'] > date('dateOut')) {
            //     $data['dateOut_err'] = '*Please select a valid date';
            // }

            // if (empty($data['dateOut'])) {
            //     $data['date_err'] = '*Please select a date';
            //     // else if date is after today
            // } else if ($data['date'] > date("Y-m-d")) {
            //     $data['dateOut_err'] = '*Please select a valid date';
            // }

            if(empty($data['bicycleID'])){
                $data['bicycleID_err'] = 'Please enter bicycle ID';
            }
            if(empty($data['problemTitle'])){
                $data['problemTitle_err'] = 'Please enter problem title';
            }
            if(empty($data['dateIn'])){
                $data['dateIn_err'] = 'Please enter date in';
            }
            if(empty($data['dateOut'])){
                $data['dateOut_err'] = 'Please enter date out';
            }
            if(empty($data['mechanicID'])){
                $data['mechanicID_err'] = 'Please enter mechanic ID';
            }
            // // if(empty($data['problemDescription'])){
            // //     $data['problemDescription_err'] = 'Please enter problem description';
            // }
            if(empty($data['finalCost'])){
                $data['finalCost_err'] = 'Please enter final cost';
            }
            if(empty($data['estCost'])){
                $data['estCost_err'] = 'Please enter estimated cost';
            }

            if(empty($data['reportID_err']) && empty($data['bicycleID_err']) && empty($data['problemTitle_err']) && empty($data['mechanicID_err']) && empty($data['finalCost_err']) && empty($data['estCost_err'])){
                // empty($data['problemDescription_err']) && empty($data['dateIn_err']) && empty($data['dateOut_err']) && 
                if($this->mechanicModel->addLogIntoTheSystem($data)){
                header('location: ' . URLROOT . '/mechanics/repairLogsControl');
                return;
            } else {
                //error page
                die("something went wrong");
                return;
            }
            } else {
                //load the view with errors        
                $this->view('mechanics/addRepairLog', $data);
                return;
            }
        }
        $this->view('mechanics/addRepairLog', $data);
    }
    
    public function createReport(){
        $data = [
            'type' => '',
            'problemTitle' => '',
            'problemDescription' => '',
            'areaID' => '',
            'accidentLocation' => '',
            'date' => '',
            'time' => '',
            'bicycleID' => '',
            'image' => '',

            'accidentTimeStamp' => '',

            'type_Err' => '',
            'problemTitle_Err' => '',
            'problemDescription_Err' => '',
            'areaID_Err' => '',
            'accidentLocation_Err' => '',
            'date_Err' => '',
            'time_Err' => '',
            'bicycleID_Err' => '',
            'image_Err' => '',

            'mapDetails' => '',
        ];
        $data['mapDetails'] = $this->mechanicModel->getAllMapDetails();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //get the data from the form
            if($_POST['type']){$data['type'] = $_POST['type'];}
            $data['problemTitle'] = $_POST['problemTitle'];
            $data['problemDescription'] = $_POST['problemDescription'];
            if($_POST['areaID']){$data['areaID'] = $_POST['areaID'];}
            $data['accidentLocation'] = $_POST['accidentLocation'];
            $data['date'] = $_POST['date'];
            $data['time'] = $_POST['time'];
            $data['bicycleID'] = $_POST['bicycleID'];
            // $data['image'] = $_POST['image'];

            //validate the report type
            if(empty($data['type'])){
                $data['type_Err'] = '*Please select a report type';
            }

            //validate the report title
            if(empty($data['problemTitle'])){
                $data['problemTitle_Err'] = '*Please enter a title';
            }

            //validate the report description
            if(empty($data['problemDescription'])){
                $data['problemDescription_Err'] = '*Please enter a description';
            }

            //if type = docking area issue, validate the area ID    
            if($data['type'] == 'Area'){
                if(empty($data['areaID'])){
                    $data['areaID_Err'] = '*Please select an area';
                }
            }

            //if type = accident, validate the accident location, date, time and bike
            if($data['type'] == 'Accident'){
                if(empty($data['accidentLocation'])){
                    $data['accidentLocation_Err'] = '*Please enter an accident location';
                }
                if(empty($data['date'])){
                    $data['date_Err'] = '*Please select a date';
                    // else if date is after today
                }else if($data['date'] > date("Y-m-d")){
                    $data['date_Err'] = '*Please select a valid date';
                }
                // print_r($data['date']);
                // print_r(date("Y-m-d"));
                if(empty($data['time'])){
                    $data['time_Err'] = '*Please select a time';
                }
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }

                // concatenate date and time to timestamp format
                $data['accidentTimeStamp'] = $data['date'] . ' ' . $data['time'];
            }else{
                $data['date'] = '';
            }

            //if type = bicycle, validate the bikeID
            if($data['type'] == 'Bicycle'){
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }
            }

            // if image size is larger than 5MB
            // if($_FILES['image']['size'] > 5242880){
            //     $data['image_Err'] = '*Image size should be less than 5MB';
            // }

            //if there are no errors 
            if(empty($data['type_Err']) && empty($data['problemTitle_Err']) && empty($data['problemDescription_Err']) && empty($data['areaID_Err']) && empty($data['accidentLocation_Err']) && empty($data['date_Err']) && empty($data['time_Err']) && empty($data['bicycleID_Err']) && empty($data['image_Err'])){
                //create the report
                // print_r($data);

                if($this->mechanicModel->createReport($data)){
                    header('location: ' . URLROOT . '/mechanics/viewReports');
                    return;
                }else{
                    // redirect to error page
                    $this->landToErrorPage();
                    die();
                }
            }else{
                //load the view with errors
                $this->view('mechanics/createReport', $data);
                return;
            }
        }

        $this->view('mechanics/createReport', $data);            
    }


    public function reportsControl(){
        // 1)Handle report data in the system
        // 2)View data
        $reportDetails = $this->mechanicModel->getReportDetails();
        $data = [
            'report_details'=> $reportDetails
        ];

        //this is not load data from the data
        $this->view('mechanics/reports', $data);
    }

    public function archivedReportsControl(){
        $reportDetails = $this->mechanicModel->getArchivedReportDetails();
        $data = [
            'report_details' => $reportDetails,
            'map_details' => '',
            // 'mechanicName_details' => '',
        ];
        $data['map_details'] = $this->mechanicModel->getAllDADetails();
        // $data['mechanicName_details'] = $this->mechanicModel->getMechanicDetails();
        //this is not load data from the data
        $this->view('mechanics/viewArchivedReports', $data);
    }

    public function archiveReports(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedRows = json_decode($_POST['selectedRows']);
            
            foreach($selectedRows as $selectedRow){
                // echo $selectedRow." ";
                $this->mechanicModel->removeReport($selectedRow);
            }
            header('Location:'.URLROOT.'/mechanics/reportsControl');
        }else{
            die("button didn't work correctly.");
        }
    }

    public function archiveAssignedReports(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedRows = json_decode($_POST['selectedRows']);
            
            foreach($selectedRows as $selectedRow){
                // echo $selectedRow." ";
                $this->mechanicModel->removeReport($selectedRow);
            }
            header('Location:'.URLROOT.'/mechanics/reportsControl');
        }else{
            die("button didn't work correctly.");
        }
    }

    public function unarchiveReports(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedRows = json_decode($_POST['selectedRows']);
            
            foreach($selectedRows as $selectedRow){
                // echo $selectedRow." ";
                $this->mechanicModel->unarchiveReport($selectedRow);
            }
            header('Location:'.URLROOT.'/mechanics/archivedReportsControl');
        }else{
            die("button didn't work correctly.");
        }
        $this->view('mechanics/archivedReportsControl');            

    }

    public function archivedRepairLogControl(){
        $repairLogDetails = $this->mechanicModel->getArchivedRepairLogDetails();
        $data = [
            'repairLog_details' => $repairLogDetails,
            'mechanicName_details' => '',
        ];
        $data['mechanicName_details'] = $this->mechanicModel->getMechanicDetails();
        //this is not load data from the data
        $this->view('mechanics/archivedRepairLog', $data);
    }

    public function archiveRepairLogs(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedRows = json_decode($_POST['selectedRows']);
            
            foreach($selectedRows as $selectedRow){
                // echo $selectedRow." ";
                $this->mechanicModel->removeRepairLog($selectedRow);
            }
            header('Location:'.URLROOT.'/mechanics/repairLogsControl');
        }else{
            die("button didn't work correctly.");
        }
        $this->view('mechanics/repairLogsControl');            

    }

    public function unarchiveRepairLogs(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $selectedRows = json_decode($_POST['selectedRows']);
            
            foreach($selectedRows as $selectedRow){
                // echo $selectedRow." ";
                $this->mechanicModel->unarchiveRepairLog($selectedRow);
            }
            header('Location:'.URLROOT.'/mechanics/archivedRepairLogsControl');
        }else{
            die("button didn't work correctly.");
        }
        $this->view('mechanics/repairLogsControl');            

    }

    public function createRepairLog(){
        $data = [
            'reportID' => '',
            'bicycleID' => '',
            'problemTitle' => '',
            'dateIn' => '',
            'dateOut' => '',
            'mechanicID' => '',
            'problemDescription' => '',
            'finalCost' => '',
            'estCost' => '',
            'repairNotes' => '',

            'reportID_err' => '',
            'bicycleID_err' => '',
            'problemTitle_err' => '',
            'dateIn_err' => '',
            'dateOut_err' => '',
            'mechanicID_err' => '',
            // 'problemDescription_err' => '',
            'finalCost_err' => '',
            'estCost_err' => '',
            'repairNotes_err' => ''
        ];
        // $data['reportID'] = $this->mechanicModel->getReportByID();


        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'reportID' => trim($_POST['reportID']),
                'bicycleID' => trim($_POST['bicycleID']),
                'problemTitle' => trim($_POST['problemTitle']),
                'dateIn' => trim($_POST['dateIn']),
                'dateOut' => trim($_POST['dateOut']),
                'mechanicID' => trim($_POST['mechanicID']),
                // 'problemDescription' => trim($_POST['problemDescription']),
                'finalCost' => trim($_POST['finalCost']),
                'estCost' => trim($_POST['estCost']),
                'repairNotes' => trim($_POST['repairNotes']),

                'reportID_err' => '',
                'bicycleID_err' => '',
                'problemTitle_err' => '',
                'dateIn_err' => '',
                'dateOut_err' => '',
                'mechanicID_err' => '',
                // 'problemDescription_err' => '',
                'finalCost_err' => '',
                'estCost_err' => '',
                'repairNotes_err' => ''
            ];
            if(empty($data['reportID'])){
                $data['reportID_err'] = 'Please enter report ID';
            }
            // if (empty($data['dateIn'])) {
            //     $data['dateIn_err'] = '*Please select a date';
            //     // else if date is after today
            // } else if ($data['dateIn'] > date('dateOut')) {
            //     $data['dateOut_err'] = '*Please select a valid date';
            // }

            // if (empty($data['dateOut'])) {
            //     $data['date_err'] = '*Please select a date';
            //     // else if date is after today
            // } else if ($data['date'] > date("Y-m-d")) {
            //     $data['dateOut_err'] = '*Please select a valid date';
            // }

            if(empty($data['bicycleID'])){
                $data['bicycleID_err'] = 'Please enter bicycle ID';
            }
            if(empty($data['problemTitle'])){
                $data['problemTitle_err'] = 'Please enter problem title';
            }
            if(empty($data['dateIn'])){
                $data['dateIn_err'] = 'Please enter date in';
            }
            if(empty($data['dateOut'])){
                $data['dateOut_err'] = 'Please enter date out';
            }
            if(empty($data['mechanicID'])){
                $data['mechanicID_err'] = 'Please enter mechanic ID';
            }
            // // if(empty($data['problemDescription'])){
            // //     $data['problemDescription_err'] = 'Please enter problem description';
            // }
            if(empty($data['finalCost'])){
                $data['finalCost_err'] = 'Please enter final cost';
            }
            if(empty($data['estCost'])){
                $data['estCost_err'] = 'Please enter estimated cost';
            }

            if(empty($data['reportID_err']) && empty($data['bicycleID_err']) && empty($data['problemTitle_err']) && empty($data['mechanicID_err']) && empty($data['finalCost_err']) && empty($data['estCost_err'])){
                // empty($data['problemDescription_err']) && empty($data['dateIn_err']) && empty($data['dateOut_err']) && 
                if($this->mechanicModel->addLogIntoTheSystem($data)){
                header('location: ' . URLROOT . '/mechanics/viewRepairLogs');
                return;
            } else {
                //error page
                die("something went wrong");
                return;
            }
            } else {
                //load the view with errors        
                $this->view('mechanics/createRepairLog', $data);
                return;
            }
        }
        $this->view('mechanics/addRepairLog', $data);
    }

    

    public function addReport()
    {
        $data = [
            'type' => '',
            'problemTitle' => '',
            'problemDescription' => '',
            'areaID' => '',
            'accidentLocation' => '',
            'date' => '',
            'time' => '',
            'bicycleID' => '',
            'image' => '',

            'accidentTimeStamp' => '',

            'type_Err' => '',
            'problemTitle_Err' => '',
            'problemDescription_Err' => '',
            'areaID_Err' => '',
            'accidentLocation_Err' => '',
            'date_Err' => '',
            'time_Err' => '',
            'bicycleID_Err' => '',
            'image_Err' => '',
            'mapDetails' => '',
        ];
        $data['mapDetails'] = $this->mechanicModel->getAllMapDetails();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //get the data from the form
            if($_POST['type']){$data['type'] = $_POST['type'];}
            $data['problemTitle'] = $_POST['problemTitle'];
            $data['problemDescription'] = $_POST['problemDescription'];
            if($_POST['areaID']){$data['areaID'] = $_POST['areaID'];}
            $data['accidentLocation'] = $_POST['accidentLocation'];
            $data['date'] = $_POST['date'];
            $data['time'] = $_POST['time'];
            $data['bicycleID'] = $_POST['bicycleID'];
            // $data['image'] = $_POST['image'];

            //validate the report type
            if(empty($data['type'])){
                $data['type_Err'] = '*Please select a report type';
            }

            //validate the report title
            if(empty($data['problemTitle'])){
                $data['problemTitle_Err'] = '*Please enter a title';
            }

            //validate the report description
            if(empty($data['problemDescription'])){
                $data['problemDescription_Err'] = '*Please enter a description';
            }

            //if type = docking area issue, validate the area ID    
            if($data['type'] == 'Area'){
                if(empty($data['areaID'])){
                    $data['areaID_Err'] = '*Please select an area';
                }
            }
            
            //if type = accident, validate the accident location, date, time and bike
            if($data['type'] == 'Accident'){
                if(empty($data['accidentLocation'])){
                    $data['accidentLocation_Err'] = '*Please enter an accident location';
                }
                if(empty($data['date'])){
                    $data['date_Err'] = '*Please select a date';
                    // else if date is after today
                }else if($data['date'] > date("Y-m-d")){
                    $data['date_Err'] = '*Please select a valid date';
                }
                // print_r($data['date']);
                // print_r(date("Y-m-d"));
                if(empty($data['time'])){
                    $data['time_Err'] = '*Please select a time';
                }
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }

                // concatenate date and time to timestamp format
                $data['accidentTimeStamp'] = $data['date'] . ' ' . $data['time'];
            }else{
                $data['date'] = '';
            }

            //if type = bicycle, validate the bikeID
            if($data['type'] == 'Bicycle'){
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }
            }

            // if image size is larger than 5MB
            // if($_FILES['image']['size'] > 5242880){
            //     $data['image_Err'] = '*Image size should be less than 5MB';
            // }

            //if there are no errors 
            if(empty($data['type_Err']) && empty($data['problemTitle_Err']) && empty($data['problemDescription_Err']) && empty($data['areaID_Err']) && empty($data['accidentLocation_Err']) && empty($data['date_Err']) && empty($data['time_Err']) && empty($data['bicycleID_Err']) && empty($data['image_Err'])){
                //add the report
                // print_r($data);

                if($this->mechanicModel->addReportIntoTheSystem($data)){
                    header('location: ' . URLROOT . '/mechanics/reportsControl');
                    return;
                }else{
                    //error page
                    die("something went wrong");
                    return;
                }
            }else{
                //load the view with errors
                $this->view('mechanics/addReport', $data);
                return;
            }
        }
        $this->view('mechanics/addReport', $data);            
    }

    public function viewAssignedReports(){       
        $assignedReports = $this->mechanicModel->getReportByUserID($_SESSION['user_ID']);

        $data = [
            'assigned_reports'=>$assignedReports,
            'mechanicID'=>$_SESSION['user_ID'],
        ];

        $this->view('mechanics/viewAssignedReports',$data);
    }
    
    public function viewReport(){
        $data = [
            'reporterID' => '',
            'reportID' => '',
            'type' => '',
            'problemTitle' => '',
            'problemDescription' => '',
            'areaID' => '',
            'accidentLocation' => '',
            'date' => '',
            'time' => '',
            'bicycleID' => '',
            'image' => '',
            'assignedMechanic' => '',
            'accidentTimeStamp' => '',

            'type_Err' => '',
            'problemTitle_Err' => '',
            'problemDescription_Err' => '',
            'areaID_Err' => '',
            'accidentLocation_Err' => '',
            'date_Err' => '',
            'time_Err' => '',
            'bicycleID_Err' => '',
            'image_Err' => '',

            'mapDetails' => '',
        ];

        
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data['mapDetails'] = $this->mechanicModel->getAllMapDetails();
            $data['reportID'] = $_GET['reportID'];

            $report = $this->mechanicModel->getReportByID($data['reportID']);
            $data['reporterID'] = $report->reporterID;
            $data['type'] = $report->reportType;
            $data['problemTitle'] = $report->problemTitle;
            $data['problemDescription'] = $report->problemDescription;
            $data['areaID'] = $report->areaID;
            $data['accidentLocation'] = $report->accidentLocation;
            $data['bicycleID'] = $report->bicycleID;    
            $data['assignedMechanic'] = $report->assignedMechanic;
            $data['accidentTimeStamp'] = $report->accidentTimeApprox;
            $data['areaID'] = $report->areaID;
            
            // split the timestamp into date and time
            $data['date'] = substr($data['accidentTimeStamp'], 0, 10);
            $data['time'] = substr($data['accidentTimeStamp'], 11, 21);

            // print_r($data['date'] . " " . $data['time'] . " " . $data['accidentTimeStamp'] . " " . $report->accidentTimeApprox . " test");
            // die("hello?");

            $this->view('mechanics/viewReport', $data);
        }
    }

    public function viewReports(){
        $data=[
            'reportsDetailObject' => '',
        ];
        
        $data['reportsDetailObject'] = $this->mechanicModel->getReportsDetails($_SESSION['user_ID']);

        $this->view('mechanics/viewReports', $data);
    }

    public function viewRepairLogs(){
        $data=[
            'repairLogsDetailObject' => '',
        ];
        
        $data['repairLogsDetailObject'] = $this->mechanicModel->getRepairLogsDetails($_SESSION['user_ID']);

        $this->view('mechanics/viewRepairLogs', $data);
    }

    public function repairLogs(){
        $data=[
            'repairLogsDetailObject' => '',
        ];
        
        $data['repairLogsDetailObject'] = $this->mechanicModel->getRepairLogsDetails($_SESSION['user_ID']);

        $this->view('mechanics/repairLogs', $data);
    }

    public function editReport(){
        $data = [
            'reportID' => '',
            'type' => '',
            'problemTitle' => '',
            'problemDescription' => '',
            'areaID' => '',
            'accidentLocation' => '',
            'date' => '',
            'time' => '',
            'bicycleID' => '',
            'image' => '',

            'accidentTimeStamp' => '',

            'type_Err' => '',
            'problemTitle_Err' => '',
            'problemDescription_Err' => '',
            'areaID_Err' => '',
            'accidentLocation_Err' => '',
            'date_Err' => '',
            'time_Err' => '',
            'bicycleID_Err' => '',
            'image_Err' => '',

            'mapDetails' => '',
        ];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            //validate and update the report
            //get the data from the form
            $data['reportID'] = $_POST['reportID'];
            if($_POST['type']){$data['type'] = $_POST['type'];}
            $data['problemTitle'] = $_POST['problemTitle'];
            $data['problemDescription'] = $_POST['problemDescription'];
            if($_POST['areaID']){$data['areaID'] = $_POST['areaID'];}
            $data['accidentLocation'] = $_POST['accidentLocation'];
            $data['date'] = $_POST['date'];
            $data['time'] = $_POST['time'];
            $data['bicycleID'] = $_POST['bicycleID'];
            // $data['image'] = $_POST['image'];

            //validate the report type
            if(empty($data['type'])){
                $data['type_Err'] = '*Please select a report type';
            }

            //validate the report title
            if(empty($data['problemTitle'])){
                $data['problemTitle_Err'] = '*Please enter a title';
            }

            //validate the report description
            if(empty($data['problemDescription'])){
                $data['problemDescription_Err'] = '*Please enter a description';
            }

            //if type = docking area issue, validate the area ID    
            if($data['type'] == 'Area'){
                if(empty($data['areaID'])){
                    $data['areaID_Err'] = '*Please select an area';
                }
            }

            //if type = accident, validate the accident location, date, time and bike
            if($data['type'] == 'Accident'){
                if(empty($data['accidentLocation'])){
                    $data['accidentLocation_Err'] = '*Please enter an accident location';
                }
                if(empty($data['date'])){
                    $data['date_Err'] = '*Please select a date';
                    // else if date is after today
                }else if($data['date'] > date("Y-m-d")){
                    $data['date_Err'] = '*Please select a valid date';
                }
                // print_r($data['date']);
                // print_r(date("Y-m-d"));
                if(empty($data['time'])){
                    $data['time_Err'] = '*Please select a time';
                }
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }

                // concatenate date and time to timestamp format
                $data['accidentTimeStamp'] = $data['date'] . ' ' . $data['time'];
            }else{
                $data['date'] = '';
            }

            //if type = bicycle, validate the bikeID
            if($data['type'] == 'Bicycle'){
                if(empty($data['bicycleID'])){
                    $data['bicycleID_Err'] = '*Please scan the bicycle';
                }
            }

            //if there are no errors 
            if(empty($data['type_Err']) && empty($data['problemTitle_Err']) && empty($data['problemDescription_Err']) && empty($data['areaID_Err']) && empty($data['accidentLocation_Err']) && empty($data['date_Err']) && empty($data['time_Err']) && empty($data['bicycleID_Err']) && empty($data['image_Err'])){
                if($this->mechanicModel->updateReport($data)){
                    header('location: ' . URLROOT . '/mechanics/viewReports');
                    return;
                }else{
                    // redirect to error page
                    $this->landToErrorPage();
                    die();
                }
            }else{
                //load the view with errors
                $this->view('mechanics/editReport', $data);
                return;
            }
            
        }else if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data['mapDetails'] = $this->mechanicModel->getAllMapDetails();
            $data['reportID'] = $_GET['reportID'];

            $report = $this->mechanicModel->getReportByID($data['reportID']);
            $data['type'] = $report->reportType;
            $data['problemTitle'] = $report->problemTitle;
            $data['problemDescription'] = $report->problemDescription;
            $data['areaID'] = $report->areaID;
            $data['accidentLocation'] = $report->accidentLocation;
            $data['bicycleID'] = $report->bicycleID;    
            $data['accidentTimeStamp'] = $report->accidentTimeApprox;
            
            // split the timestamp into date and time
            $data['date'] = substr($data['accidentTimeStamp'], 0, 10);
            $data['time'] = substr($data['accidentTimeStamp'], 11, 21);

            // print_r($data['date'] . " " . $data['time'] . " " . $data['accidentTimeStamp'] . " " . $report->accidentTimeApprox . " test");
            // die("hlello?");

            $this->view('mechanics/editReport', $data);
        }
    }

    public function deleteReport(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $reportID = $_GET['reportID'];

            if($this->mechanicModel->deleteReport($reportID)){
                header('location: ' . URLROOT . '/mechanics/viewReports');
                return;
            }else{
                // redirect to error page
                $this->landToErrorPage();
                die();
            }
        }else{
            header('location: ' . URLROOT . '/mechanics/viewReports');
            return;
        }
    }

    public function dockingAreas(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
             *  */ 
            
            // load mechanic's DA control
            //code will implement here
            $DADetails = $this->mechanicModel->getDADetails();
            $data = [
                'DA_Details' => $DADetails
            ];
            
            //view details
            $this->view('mechanics/dockingareas', $data);
    }

    public function bicyclesControl(){
        /**
         * Tasks 
         * 1) Load the data
         * 2) View the data
         **/
        $bicycleDetails = $this->mechanicModel->getBicycleDetails();
        $data = [
            'bicycle_details' => $bicycleDetails
        ];

        //view details
        $this->view('mechanics/bicycles', $data);
        
    }

    // after addBike form filled if they are valid then insert data into the system
    public function addBicycle(){
        /**
         *  Task
         *      This function task is validate data from the addBike form and,
        */
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // process form
            //init data
            $data = [
                'bikeOwnerID' => trim($_POST['bikeOwnerID']),
                'frameSize' => trim($_POST['frameSize']),
                'dateAcquired' => trim($_POST['dateAcquired']),
                'datePutInUse' => trim($_POST['datePutInUse']),
                'status' => trim($_POST['status']),
                'currentDA' => trim($_POST['currentDA']),

                'bikeOwnerID_err' => '',
                'frameSize_err' => '',
                'dateAcquired_err' => '',
                'datePutInUse_err' => '',
                'status_err' => '',
                'currentDA_err' => '',
            ];

            //validate submitted data
            //validate bicycle owner ID
            if(empty($data['bikeOwnerID'])){
                $data['bikeOwnerID_err'] = '*enter bicycle owner ID';
            } 

            //validate frame size
            if(empty($data['frameSize'])){
                $data['frameSize_err'] = '*enter frame size';
            }

            //validate date acquired
            if(empty($data['dateAcquired'])){
                $data['dateAcquired_err'] = '*enter date acquired';
            }

            if(empty($data['bikeOwnerID_err']) && empty($data['frameSize_err']) && empty($data['dateAcquired_err']) && empty($data['datePutInUse_err']) && empty($data['status_err']) && empty($data['currentDA_err'])){
                //every things up to ready 

                // add bike
                if($this->mechanicModel->addBicycleIntoTheSystem($data)){
                    // next implementation should be land into the right position according to the role
                    // $this->bicyclesControl();
                    header('Location:'.URLROOT.'/mechanics/bicyclesControl');
                }else{
                    die('something went wrong');
                }
            }
            else{
                $this->view('mechanics/addBicycle', $data);
            }

        }else{
            //init data
            $data = [
                'bikeOwnerID' => '',
                'frameSize' => '',
                'dateAcquired' => '',
                'datePutInUse' => '',
                'status' => '',
                'currentDA' => '',
            
                'bikeOwnerID_err' => '',
                'frameSize_err' => '',
                'dateAcquired_err' => '',
                'datePutInUse_err' => '',
                'status_err' => '',
                'currentDA_err' => '',

            ];
            $this->view('mechanics/addBicycle', $data);
        }
    }

    public function viewDockingAreas(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'areaID' => intval(trim($_GET['areaID'])),
                'areaObject' => ''
            ];
            $data['areaObject'] = $respectiveUserDetail = $this->mechanicModel->findAreaByID($data['areaID']);
            $this->view('mechanics/viewDockingAreas', $data);
        }
        else{
            die("button did not work correctly.");
        }
    }

    public function viewBicycle(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'logID' => intval(trim($_GET['logID'])),
                'logDetailObject' => ''
            ];
            $data['logDetailObject'] = $respectiveUserDetail = $this->mechanicModel->findLogByID($data['logID']);
            $this->view('mechanics/viewBicycle', $data);
        }
        else{
            die("button didn't work correctly.");
        }
    }  

    public function editBicycleDetails(){
        /**
         *  Task one load the user detail button
        */
        //die("help");
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'bicycleID' => intval(trim($_GET['bicycleID'])),
                'bicycleDetailObject' => '',

                'bikeOwnerID' => '',
                'frameSize' => '',
                'dateAcquired' => '',
                'datePutInUse' => '',
                'status' => '',
                'currentDA' => '',

                'bikeOwnerID_err' => '',
                'frameSize_err' => '',
                'dateAcquired_err' => '',
                'datePutInUse_err' => '',
                'status_err' => '',
                'currentDA_err' => '',
            ];
            $data['bicycleDetailObject'] = $respectiveUserDetail = $this->mechanicModel->findBicycleByID($data['bicycleID']);
            $this->view('mechanics/viewBicycleDetails', $data);

        }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $data = [
                'bicycleDetailObject' => '',
                
                'bicycleID' => intval(trim($_POST['bicycleID'])),
                'bikeOwnerID' => trim($_POST['bikeOwnerID']),
                'frameSize' => trim($_POST['frameSize']),
                'dateAcquired' => trim($_POST['dateAcquired']),
                'datePutInUse' => trim($_POST['datePutInUse']),
                'status' => trim($_POST['status']),
                'currentDA' => trim($_POST['currentDA']),

                'bikeOwnerID_err' => '',
                'frameSize_err' => '',
                'dateAcquired_err' => '',
                'datePutInUse_err' => '',
                'status_err' => '',
                'currentDA_err' => '',
            ];
            $data['bicycleDetailObject'] = $respectiveUserDetail = $this->mechanicModel->findBicycleByID($data['bicycleID']);
            //validate submitted data
                //validate bicycle owner ID
                if(empty($data['bikeOwnerID'])){
                    $data['bikeOwnerID_err'] = '*Bike Owner ID is Required';
                } 

                //validate frame size
                if(empty($data['frameSize'])){
                    $data['frameSize_err'] = '*Frame Size is required';
                }else if(!is_numeric($data['frameSize'])){
                    $data['frameSize_err'] = '*Frame Size must be a number';
                }

                //validate date acquired
                if(empty($data['dateAcquired'])){
                    $data['dateAcquired_err'] = '*Date Acquired is required';
                }

                //validate DA
                if(empty($data['currentDA'])){
                    $data['currentDA_err'] = '*Current Docking Area is required';
                }else if(!is_numeric($data['currentDA'])){
                    $data['currentDA_err'] = '*Current Docking Area must be a number';
                }
            //
            

            if(empty($data['bikeOwnerID_err']) && empty($data['frameSize_err']) && empty($data['dateAcquired_err']) && empty($data['datePutInUse_err']) && empty($data['status_err']) && empty($data['currentDA_err'])){
                //every things up to ready 

                // update bike
                if($this->mechanicModel->updateBicycle($data)){
                    // next implementation should be land into the right position according to the role
                    header('Location:'.URLROOT.'/mechanics/bicycleControl');
                }else{
                    //have an issue where, even if you don't update anything and click update, the above if returns false
                    header('Location:'.URLROOT.'/mechanics/bicycleControl');
                    //die('something went wrong!');
                }
            }
            else{
                $this->view('mechanics/viewBicycleDetails', $data);
            }

        }else{
            die("button didn't work correctly.");
        }       
    }

    public function addBicycleIntoTheSystem($data)
    {
        $bikeOwnerID = $data['bikeOwnerID'];
        $frameSize = $data['frameSize'];
        $dateAcquired = $data['dateAcquired'];
        $datePutInUse = $data['datePutInUse'];
        $status = intval($data['status']);
        $currentDA = $data['currentDA'];
        

        $temp = "INSERT INTO bicycles (bikeOwnerID, frameSize, dateAcquired, datePutInUse, status, currentDA ) VALUES ('$bikeOwnerID', '$frameSize', '$dateAcquired', '$datePutInUse', '$status', '$currentDA')";
    }

    public function scanQR(){
        //check if a ride is already active and the user simply refreshed the page
        if($this->redirectIfActive()){
            return;
        }

        $data = [
            'rideDetailObject_err' => '',
        ];
        $this->view('mechanics/scanQR', $data);
    }

    function redirectIfActive(){
        if(isset($_SESSION['user_ID'])){
            $currentRide = $this->mechanicModel->checkIfActive($_SESSION['user_ID']);
            if($currentRide){
                //got to ongoing ride page with userID as a get request
                header('location: ' . URLROOT . '/mechanics/activeRide?rideLogID=' . $currentRide->rideLogID);
                return true;
            }else{
                return false;
            }
        }else{
            header('location: ' . URLROOT . '/users/login');
        }
    }

    /////////////////Internal functions

        //function to find the closest point to a given point on a cartesian plane
        //inputs: x and y coordinates of the point, and an array of points
        //output: the index of the closest point in the array
        function closestPoint($x, $y, $points) {
            //convert x  and y from lat long to cartesian

            $closest = 0;
            $distance = 0;
            $minDistance = 0;
            foreach ($points as $key => $point) {
                $distance = sqrt(pow($x - $point[0], 2) + pow($y - $point[1], 2));
                if ($distance < $minDistance || $minDistance == 0) {
                    $minDistance = $distance;
                    $closest = $key;
                }
            }
            return $closest;
        }

        //function to check if a point is within a certain radius of another
        //inputs: x and y coordinates of two points, radius
        //output: true or false

        function withinRadius($km, $radius) {
            
            // if (($x1 == $x2) && ($y1 == $y2)) {
            //     return 0;
            // }else{
            //     $theta = $y1 - $y2;
            //     $dist = sin(deg2rad($x1)) * sin(deg2rad($x2)) +  cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($theta));
            //     $dist = acos($dist);
            //     $dist = rad2deg($dist);
            //     $km = $dist * 60 * 1.1515 * 1.609344;
            // }
            //die($km);
            if ($km <= $radius) {
                return 1;
            }else{
                return 0;
            }
        }

        function distance($x1, $y1, $x2, $y2) {
            
            if (($x1 == $x2) && ($y1 == $y2)) {
                return 0;
            }else{
                $theta = $y1 - $y2;
                $dist = sin(deg2rad($x1)) * sin(deg2rad($x2)) +  cos(deg2rad($x1)) * cos(deg2rad($x2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $km = $dist * 60 * 1.1515 * 1.609344;
            }
            return $km;
        }

        

        public function landToErrorPage(){
            //load the error page only view
            $this->view('users/error');
        }

    }

    ////////////////////////////////////////TRACK CLASS

    // class Track {
    //     // (A) CONSTRUCTOR - CONNECT TO DATABASE
    //     public $pdo = null;
    //     public $stmt = null;
    //     public $error = "";
    //     function __construct () {
    //       $this->pdo = new PDO(
    //         "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
    //         DB_USER, DB_PASSWORD, [
    //         PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    //         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    //       ]);
    //     }
      
    //     // (B) DESTRUCTOR - CLOSE CONNECTION
    //     function __destruct () {
    //       if ($this->stmt !== null) { $this->stmt = null; }
    //       if ($this->pdo !== null) { $this->pdo = null; }
    //     }
      
    //     // (C) HELPER FUNCTION - EXECUTE SQL QUERY
    //     function query ($sql, $data=null) {
    //       $this->stmt = $this->pdo->prepare($sql);
    //       $this->stmt->execute($data);
    //     }

          

