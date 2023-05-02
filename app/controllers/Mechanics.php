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



    // public function addReport()
    // {
    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         // process form
    //         //init data
    //         $data = [
    //             'Rid' => trim($_POST['Report_ID']),
    //             'RLid' => trim($_POST['Repair_Log_ID']),
    //             'Bid' => trim($_POST['BicycleID']),
    //             'Ptitle' => trim($_POST['Problem_Title']),
    //             'Din' => trim($_POST['Date_In']),
    //             'Tin' => trim($_POST['Time_In']),
    //             'Mid' => trim($_POST['Mechanic_ID']),
    //             'SolnDesc' => trim($_POST['SolutionDescription']),
    //             'Tag' => trim($_POST['Tags']),

    //             'Rid_err' => '',
    //             'RLid_err' => '',
    //             'Bid_err' => '',
    //             'Ptitle_err' => '',
    //             'Din_err' => '',
    //             'Tin_err' => '',
    //             'Mid_err' => '',
    //             'SolnDesc_err' => '',
    //             'Tag_err' => '',
    //         ];
    //         $this->mechanicModel->addReport($data);
    //         redirect('mechanics/mechanicOp');
    //     } else
    //         $this->view('mechanics/addReport', [
    //             'Rid_err' => '',
    //             'RLid_err' => '',
    //             'Bid_err' => '',
    //             'Ptitle_err' => '',
    //             'Din_err' => '',
    //             'Tin_err' => '',
    //             'Mid_err' => '',
    //             'SolnDesc_err' => '',
    //             'Tag_err' => '',
    //         ]);
    // }


    // public function addReportToTheSystem()
    public function addReport()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // process form
            //init data
            $data = [
                'Rid' => trim($_POST['Report_ID']),
                'RLid' => trim($_POST['Repair_Log_ID']),
                'Bid' => trim($_POST['BicycleID']),
                'Ptitle' => trim($_POST['ProblemTitle']),
                'Din' => trim($_POST['DateIN']),
                'Tin' => trim($_POST['TimeIN']),
                'Mid' => trim($_POST['MechanicID']),
                'SolnDesc' => trim($_POST['SolutionDescription']),
                'Tag' => trim($_POST['Tags']),

                'Rid_err' => '',
                'RLid_err' => '',
                'Bid_err' => '',
                'Ptitle_err' => '',
                'Din_err' => '',
                'Tin_err' => '',
                'Mid_err' => '',
                'SolnDesc_err' => '',
                'Tag_err' => '',
            ];

            //validate data
            //validate first_name
            //validate last name
            if (empty($data['Rid'])) {
                $data['Rid_err'] = 'Enter Solution Description';
            }

            if (empty($data['RLid'])) {
                $data['RLid_err'] = '*Enter Report Log ID';
            }

            //validate phone number
            if (empty($data['Bid'])) {
                $data['Bid_err'] = '*Enter Bicycle ID';
            } else {
                //check database whether it is available.
            }

            //validate email
            if (empty($data['Ptitle'])) {
                $data['Ptitle_err'] = '*Enter Problem Title';


                if (empty($data['Din'])) {
                    $data['Din_err'] = '*Enter Date';
                }

                if (empty($data['Tin'])) {
                    $data['Tin_err'] = '*Enter Time In';
                }

                if (empty($data['Mid'])) {
                    $data['Mid_err'] = '*Enter Mechanic ID';
                }

                if (empty($data['SolnDesc'])) {
                    $data['SolnDesc_err'] = '*Enter Solution Description';
                }

                if (empty($data['Tag'])) {
                    $data['Tag_err'] = '*Enter Tag';
                }

                // if(empty($data['email_err']) && empty($data['password_err']) && empty($data['fName_err']) && empty($data['lName_err']) && empty($data['pNumber_err']) && empty($data['nic_err'])){
                // add new report
                if ($this->mechanicModel->addReport($data)) {
                    redirect('mechanics/addReportSuccess');
                } else {
                    redirect('mechanics/addReporterror');
                    die('Something went wrong');
                }
                // }else{
                // $this->view('mechanics/addReport', $data);
                // }

            } else {
                //init data
                $data = [
                    'Rid' => '',
                    'RLid' => '',
                    'Bid' => '',
                    'Ptitle' => '',
                    'Din' => '',
                    'Tin' => '',
                    'Mid' => '',
                    'SolnDesc' => '',
                    'Tag' => '',

                    'Rid_err' => '',
                    'RLid_err' => '',
                    'Bid_err' => '',
                    'Ptitle_err' => '',
                    'Din_err' => '',
                    'Tin_err' => '',
                    'Mid_err' => '',
                    'SolnDesc_err' => '',
                    'Tag_err' => '',

                ];
                $this->view('mechanics/addReport', $data);
            }
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
                'docking_area_details' => $DADetails
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


    public function viewBicycle(){
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $data = [
                'logID' => intval(trim($_GET['logID'])),
                'logDetailObject' => ''
            ];
            $data['logDetailObject'] = $respectiveUserDetail = $this->mechanicModel->findLogbyID($data['logID']);
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
