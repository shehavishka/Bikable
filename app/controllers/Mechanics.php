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

    public function repairLogsControl(){
        /**
         * Task 
         *      1.) handle repair in the system
         *      2.) View the data
        **/ 
    
        // load mechanic's repairLog control
        //code will implement here
        $repairLogDetails = $this->mechanicModel->getRepairLogDetails();
        $data = [
            'repairLog_details' => $repairLogDetails
        ];

        //this is not load data from the data
        $this->view('mechanics/repairLogs', $data);
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

    public function addLog()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'RLid' => trim($_POST['Repair_Log_ID']),
                'Bid' => trim($_POST['BicycleID']),
                'Ptitle' => trim($_POST['Problem_Title']),
                'Din' => trim($_POST['Date_In']),
                'Tin' => trim($_POST['Time_In']),
                'Mid' => trim($_POST['Mechanic_ID']),
                'ProbDesc' => trim($_POST['Problem_Description']),
                'RepDesc' => trim($_POST['Repair_Description']),
                'EstCost' => trim($_POST['Estimated_cost']),
                'Dout' => trim($_POST['Date_Out']),
                'FinCost' => trim($_POST['Final_Cost']),

                'RLid_err' => '',
                'Bid_err' => '',
                'Ptitle_err' => '',
                'Din_err' => '',
                'Tin_err' => '',
                'Mid_err' => '',
                'ProbDesc_err' => '',
                'RepDecs_err' => '',
                'EstCost_err' => '',
                'Dout_err' => '',
                'FinCost' => '',
            ];

            $this->mechanicModel->addLog($data);
            redirect('mechanics/mechanicLandPage');

        } else
            $this->view('mechanics/addLog',[
                'RLid_err' => '',
                'Bid_err' => '',
                'Ptitle_err' => '',
                'Din_err' => '',
                'Tin_err' => '',
                'Mid_err' => '',
                'ProbDesc_err' => '',
                'RepDesc_err' => '',
                'EstCost_err' => '',
                'Dout_err' => '',
                'FinCost' => '',
        ]);
    }

    public function addLogToTheSystem()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'RLid' => trim($_POST['Repair_Log_ID']),
                'Bid' => trim($_POST['BicycleID']),
                'Ptitle' => trim($_POST['Problem_Title']),
                'Din' => trim($_POST['Date_In']),
                'Tin' => trim($_POST['Time_In']),
                'Mid' => trim($_POST['Mechanic_ID']),
                'ProbDesc' => trim($_POST['Problem_Description']),
                'RepDesc' => trim($_POST['Repair_Description']),
                'EstCost' => trim($_POST['Estimated_cost']),
                'Dout' => trim($_POST['Date_Out']),
                'FinCost' => trim($_POST['Final_Cost']),

                'RLid_err' => '',
                'Bid_err' => '',
                'Ptitle_err' => '',
                'Din_err' => '',
                'Tin_err' => '',
                'Mid_err' => '',
                'ProbDesc_err' => '',
                'RepDesc_err' => '',
                'EstCost_err' => '',
                'Dout_err' => '',
                'FinCost' => '',
            ];

            if (empty($data['RLid'])) {
                $data['RLid_err'] = 'Enter Solution Description';
            }

            if (empty($data['Bid'])) {
                $data['Bid_err'] = 'Enter Bicycle ID';
            }

            if (empty($data['Ptitle'])) {
                $data['Ptitle_err'] = 'Enter Problem Title';
            }

            if (empty($data['Din'])) {
                $data['Din_err'] = 'Enter Date in';
            }

            if (empty($data['Tin'])) {
                $data['Tin_err'] = 'Enter Time in';
            }

            if (empty($data['Mid'])) {
                $data['Mid_err'] = 'Enter Mechanic ID';
            }

            if (empty($data['ProbDesc'])) {
                $data['ProbDesc_err'] = 'Enter Problem Description';
            }

            if (empty($data['RepDesc'])) {
                $data['RepDesc_err'] = 'Enter Repair Description';
            }

            if (empty($data['EstCost'])) {
                $data['EstCost_err'] = 'Enter Estimated Cost';
            }

            if (empty($data['Dout'])) {
                $data['Dout_err'] = 'Enter Date out';
            }

            if (empty($data['FinCost'])) {
                $data['FinCost'] = 'Enter Final Cost';
            }

            if ($this->mechanicModel->addLog($data)) {
                redirect('mechanics/addLogSuccess');
            } else {
                redirect('mechanics/addLogerror');
                die('something went wrong');
            }
        }
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
                    header('location: ' . URLROOT . '/mechanics/reports');
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
                    header('location: ' . URLROOT . '/mechanics/reports');
                    return;
                }else{
                    //error page
                    die("something went wrong");
                    return;
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

    public function bicycleControl(){
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

          
}
