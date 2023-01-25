<?php
    class Mechanics extends Controller{
        private $mechanicModel;
    

        public function __construct(){
            $this->mechanicModel = $this->model('model');
        }

        public function mechanicOp(){


            //load Report details
            $mechanic_details = $this->mechanicModel->getReport();
            $data = [
                'mechanic_details'=> $mechanic_details
            ];

            // view details
            $this->view('mechanics/mechanicsV', $data);

        }

        public function addLog(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                    'FinCost'=> trim($_POST['Final_Cost']),

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
                    'FinCost'=> '',
                ];
                $this -> mechanicModel -> addLog($data);
                redirect('mechanics/mechanicOp');
            }

            else
            $this -> view('mechanics/addLog',[
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
                'FinCost'=> '',
            ]);
        }

        public function addLogToThesystem(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                    'FinCost'=> trim($_POST['Final_Cost']),

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
                    'FinCost'=> '',
                ];

                if(empty($data['RLid'])){
                    $data['RLid_err'] = 'Enter Solution Description';
                }

                if(empty($data['Bid'])){
                    $data['Bid_err'] = 'Enter Bicycle ID';
                }

                if(empty($data['Ptitle'])){
                    $data['Ptitle_err'] = 'Enter Problem Title';
                }

                if(empty($data['Din'])){
                    $data['Din_err'] = 'Enter Date in';
                }

                if(empty($data['Tin'])){
                    $data['Tin_err'] = 'Enter Time in';
                }

                if(empty($data['Mid'])){
                    $data['Mid_err'] = 'Enter Mechanic ID';
                }

                if(empty($data['ProbDesc'])){
                    $data['ProbDesc_err'] = 'Enter Problem Description';
                }

                if(empty($data['RepDesc'])){
                    $data['RepDesc_err'] = 'Enter Repair Description';
                }

                if(empty($data['EstCost'])){
                    $data['EstCost_err'] = 'Enter Estimated Cost';
                }

                if(empty($data['Dout'])){
                    $data['Dout_err'] = 'Enter Date out';
                }

                if(empty($data['FinCost'])){
                    $data['FinCost'] = 'Enter Final Cost';
                }

                if($this->mechanicModel->addLog($data)){
                    redirect('mechanics/addLogSuccess');
                }else{
                    redirect('mechanics/addLogerror') ;
                    die('something went wrong');
                }
            }
        }   


        public function addReport(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'Rid' => trim($_POST['Report_ID']),
                    'RLid' => trim($_POST['Repair_Log_ID']),
                    'Bid' => trim($_POST['BicycleID']),
                    'Ptitle' => trim($_POST['Problem_Title']),
                    'Din' => trim($_POST['Date_In']),
                    'Tin' => trim($_POST['Time_In']),
                    'Mid' => trim($_POST['Mechanic_ID']),
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
                $this -> mechanicModel -> addReport($data);
                redirect('mechanics/mechanicOp');
            }
            
            else
            $this -> view('mechanics/addReport',[
                'Rid_err' => '',
                'RLid_err' => '',
                'Bid_err' => '',
                'Ptitle_err' => '',
                'Din_err' => '',
                'Tin_err' => '',
                'Mid_err' => '',
                'SolnDesc_err' => '',
                'Tag_err' => '',
                ]);
        }


        public function addReportToThesystem(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
                if(empty($data['Rid'])){
                    $data['Rid_err'] = 'Enter Solution Description';
                }

                if(empty($data['RLid'])){
                    $data['RLid_err'] = '*Enter Report Log ID';
                }

                //validate phone number
                if(empty($data['Bid'])){
                    $data['Bid_err'] = '*Enter Bicycle ID';
                }else{
                    //check database whether it is available.
                }

                //validate email
                if(empty($data['Ptitle'])){
                    $data['Ptitle_err'] = '*Enter Problem Title';


                if(empty($data['Din'])){
                    $data['Din_err'] = '*Enter Date';
                }

                if(empty($data['Tin'])){
                    $data['Tin_err'] = '*Enter Time In';
                }

                if(empty($data['Mid'])){
                    $data['Mid_err'] = '*Enter Mechanic ID';
                }

                if(empty($data['SolnDesc'])){
                    $data['SolnDesc_err'] = '*Enter Solution Description';
                }

                if(empty($data['Tag'])){
                    $data['Tag_err'] = '*Enter Tag';
                }

                // if(empty($data['email_err']) && empty($data['password_err']) && empty($data['fName_err']) && empty($data['lName_err']) && empty($data['pNumber_err']) && empty($data['nic_err'])){
                    // add new report
                    if($this->mechanicModel->addReport($data)){
                        redirect('mechanics/addReportSuccess');
                    }else{
                        redirect('mechanics/addReporterror') ;
                        die('Something went wrong');
                    }
                // }else{
                    // $this->view('mechanics/addReport', $data);
                // }

            }else{
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
    }