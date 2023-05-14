<?php

    // this class is for owner's controller
    /**
     * 1. ) Owner's landing page (ownerLandPage)
     
     * 2. ) Owner's profile page (ownerViewsHisOwnProfile)
     * 3. ) Owner edits his new details (ownerEditsHisNewDetails)
     * 4. ) Owner updates his profile picture (ownerUpdatesHisProfilePicture)
     * 5. ) Owner submits his new password (ownerSubmitsHisNewPassword)
     
     * 6. ) Owner adds a new user to the system (addUserToTheSystem)
     * 7. ) Owner handle administrator page (administrator)
     * 8. ) Owner handle administrator search (search administrator)
     * 9. ) Owner handle mechanic page (mechanic)
     * 10.) Owner handle mechanic search (search_mechanic)
     * 11.) Owner handle rider page (riders)
     * 12.) Owner handle rider search (search_riders)
     * 13.) Owner handle bicycle owner page (bicycleOwner)
     * 14.) Owner handle bicycle owner search (search_bicycleOwners)
     
     * 15.) Owner handle repair log page (repairLog) -> **** not completed
     
     * 16.) Owner handle docking areas page (dockingAreas)
     * 17.) Owner handle docking areas search (search_dockingAreas)
     * 18.) Add docking area to the system (addDockingAreaToSystem)
     * 19.) Delete Docking Areas selected (deleteDockingArea)
     * 20.) Edit Docking Area Details (editDADetails)
     
     * 21.) Owner handle bicycle control page (bicyclesControl)
     * 22.) Owner handle search bicycle (search_bicycles)
     * 23.) Add bicycle to the system (addBicycle)
     * 24.) Delete Bike selected (deleteBicycles)
     * 25.) Edit bicycle (editBicycleDetails)
     
     * 26.) Owner handle rides control page (ridesControl)
     * 27.) Rides search (search_rides)
     
     * 28.) Owner handle reports control page (reportsControl)
     * 29.) Reports search (search_reports)
     * 30.) Owner handle edit report details page (editReportDetails)
     * 31.) archived reports (archivedReports)
     * 32.) unarchive reports (unarchiveReports)
     * 33.) Owner handle archived reports page (archivedReportsControl)
     * 34.) Owner handle accident reports page (AccidentReportsControl)
     * 35.) Owner handle bicycle reports page (BicycleReportsControl)
     * 36.) Owner handle DA reports page (DAReportsControl)

     * 37.) (inbuilt) Generate password length 8
     * 38.) (inbuilt) Send email to the user
     * 39) (inbuilt) Send email to the user when current password is changed
     * 40.) (inbuilt) land to the error page
     * 41.) user profile view button (userProfileViewButton)
     * 42.) suspend and release user (suspendReleaseUser)
     * 43.) Statistics page (statisticsPageView)
     * 44.) Set fare and rate (setFareAndRate)
     * 
    */

    // dependencies for phpmailer
    use PHPMailer\PHPMailer\PHPMailer;

    class Owners extends Controller{

        // Owner connects to the database using this variable.
        private $ownerModel;

        public function __construct(){

            // ownerModel variable connect to the Owner model
            $this->ownerModel = $this->model('Owner');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 1. ) Owner's landing page (ownerLandPage)
        public function ownerLandPage(){
            /**
             *    There are,
             *          1.) Three tables
             *              a.) Reports table
             *              b.) Reports log table
             *              c.) Bicycle details table
             *          2.) 4 buttons -> done
             *          3.) 1 map -> done
             *          4.) 2 graphs
             *        
            */

            // docking areas details for the map take from the database
            $dockingAreasDeatails = $this->ownerModel->ownerLandPageMapDetails();

            // reportsID, assignedMechanic take from the database
            $reportsIDAssignedMechanicIDDetails = $this->ownerModel->ownerLandpageReportIDAssignedMechanic();
            
            // repaire log details take from the database
            $repairLogDetails = $this->ownerModel->ownerLandpageRepairLogDetails();

            // bicycles details take from the database
            $bicyclesDetails = $this->ownerModel->ownerLandpageBicyclesDetails();

            //bike status count
            $bikecounts = $this->ownerModel->getBicycleCountByStatus();
            
            // this is like dictionary
            $activeBikes = $bikecounts[0]->count;
            $inactiveBikes = $bikecounts[1]->count;
            $deletedBikes = $bikecounts[2]->count;

            $data = [
                'docking_areas_details' => $dockingAreasDeatails,
                'reportID_assignedMechanicID_details' => $reportsIDAssignedMechanicIDDetails,
                'repair_log_details' => $repairLogDetails,
                'bicycles_details' => $bicyclesDetails,
                
                'activeBikes' => $activeBikes,
                'inactiveBikes' => $inactiveBikes,
                'deletedBikes' => $deletedBikes
            ];

            // load the data form UI and send all data to the UI
            $this->view('owners/ownerLandPage', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 2. ) Owner's profile page (ownerViewsHisOwnProfile)
        public function ownerViewsHisOwnProfile(){
           /**
            * There are,
            *      1.) Profile Picture -> done
            *      2.) User ID
            *      3.) Last Logged in
            *      4.) Registered Date
            *      5.) Session Details need to be added -> done
            */

            $this->view('owners/ownerViewsHisOwnProfile');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 3. ) Owner edits his details (ownerSubmitsHisNewDetails)
        public function ownerEditsHisNewDetails(){
            /**
             * This function is for update owner's details
             * need to validate submitted data 
            */

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'nic' => trim($_POST['nic_number']),
                    // 'status' => trim($_POST['status']),
                    // 'pNumber' => trim($_POST['contact_number']),
                    // 'userRole' => strtolower(trim($_POST['user_role'])),
                    // 'userPassword' => '', // this generate after confirmed entered details are ready.

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'status_err' => '',
                    // 'pNumber_err' => '',
                    // 'userRole_err' => ''
                ];

                //validate first name weather it is empty or not
                if(empty($data['fName'])){
                    $data['fName'] = $_SESSION['user_fName'];
                } 

                //validate last name weather it is empty or not
                if(empty($data['lName'])){
                    $data['lName'] = $_SESSION['user_lName'];
                }

                //validate email weather it is empty or not
                if(empty($data['email'])){
                    $data['email'] = $_SESSION['user_email'];
                }else{
                    // //check weather email is availble in database
                    // // true means that email is already taken.
                    // if($this->ownerModel->findUserByEmail($data['email'])){
                    //     $data['email_err'] = "*email is already taken";
                    // }else{
                    //     //update email
                    //     //pass
                    // }
                }

                //validate nic weather it is empty or not
                if(empty($data['nic'])){
                    $data['nic'] = $_SESSION['user_NIC'];
                }else{
                    //check weather nic is availble in database
                    // true means that nic is already taken.
                    // if($this->ownerModel->findNicNumber($data['nic'])){
                    //     $data['nic_err'] = "*NIC is already taken";
                    // }else{
                    //     //update nic
                    //     //pass
                    // }
                }

                //validate phone number weather it is empty or not
                // if(empty($data['pNumber'])){
                //     $data['pNumber_err'] = '*enter phone Number';
                // }else{
                //     //check weather phone number is availble in database
                //     // true means that phone number is already taken.
                //     if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                //         
                //         $data['pNumber_err'] = "*Phone Number is already taken";
                //     }else{
                //         //pass
                //     }
                //}

                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) &&  empty($data['nic_err'])){
                    //if all data are valid then update user details
                    if($this->ownerModel->ownerUpdatesHisData($data)){
                        //update session variables
                        $_SESSION['user_fName'] = $data['fName'];
                        $_SESSION['user_lName'] = $data['lName'];
                        $_SESSION['user_email'] = $data['email'];                       
                        $_SESSION['user_NIC'] = $data['nic'];
                        //redirect to the profile page
                        $this->view('owners/ownerViewsHisOwnProfile');
                        echo "<script>
                                Swal.fire(
                                    'Changed successfully',
                                    'Personal Data Changed Successfully',
                                )
                            </script>";
                    }else{
                        // die('something went wrong');
                        //redirect to the error page
                        $this->landToErrorPage();
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/ownerEditsHisOwnProfile', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'email' => '',
                    'nic' => '',
                    // 'pNumber' => '',
                    // 'password' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'pNumber_err' => '',
                    // 'password_err' => '',
                ];

                //load the view
                $this->view('owners/ownerEditsHisOwnProfile', $data);
            }

        }
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 4. ) Owner updates his profile picture (ownerUpdatesHisProfilePicture)
        public function ownerUpdatesHisProfilePicture(){
            /**
             * There are,
             *      1.) Profile  Picture  upload
            */
            if(isset($_POST["submit"])){
                $img_name = $_FILES['image1']['name'];
                $img_size = $_FILES['image1']['size'];
                $tmp_name = $_FILES['image1']['tmp_name'];
                $error = $_FILES['image1']['error'];
            
                if($error === 0){
                    if($img_size > 12500000){
                        // $data['image1_err'] = "Sorry, your first image is too large.";
                        $this->landToErrorPage();
                    }
                    else{
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //Extension type of image(jpg,png)
                        $img_ex_lc = strtolower($img_ex);
            
                        $allowed_exs = array("jpg", "jpeg", "png"); 
            
                        if(in_array($img_ex_lc, $allowed_exs)){

                            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
                            $img_upload_path = dirname(APPROOT).'/public/images/profile_pictures/'.$new_img_name;
                            move_uploaded_file($tmp_name, $img_upload_path);
                            // $data['image1'] = $new_img_name;
            
                            //Insert into database
                            if($this->ownerModel->ownerUploadsHisProfilePicture($new_img_name)){
                                $_SESSION['user_picture'] = $new_img_name;
                                $this->view('owners/ownerEditsHisOwnProfile');
                                echo "<script>
                                        Swal.fire(
                                            'Profile picture changed successfully',
                                            'success'
                                        )
                                    </script>";
                            }
                            else{
                                die('Something went wrong');
                            }
                        }
                        else{
                            // $data['image1_err'] = "You can't upload files of this type";
                            $this->landToErrorPage();
                        }
                    }
                }
                else{
                    // $data['image1_err'] = "Unknown error occurred!";
                    $this->landToErrorPage();
                }
            }else{
                // $data['image1_err'] = 'Please upload atleast one image';
                $this->landToErrorPage();
            }
        }
          
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 5. ) Owner submits his new password (ownerSubmitsHisNewPassword)
        public function ownerChangesHisPassword(){
            // load the form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'currentPassword' => trim($_POST['current-password']),
                    'newPassword' => trim($_POST['new-password']),
                    'confirmPassword' => trim($_POST['confirm-password']),

                    'currentPassword_err' => '',
                    'confirmPassword_err' => '',

                ];

                // store the user id in a variable
                $userID = $_SESSION['user_ID'];

                //find user details by user id
                $userDetails = $this->ownerModel->findUserByUserID($userID);

                // check weather current password is correct or not
                if($userDetails){

                    $userHashedValue = $userDetails->password;
                    if(password_verify(strval($data['currentPassword']),strval($userHashedValue))){
                        //verified
                    }else{
                        // if not verified
                        $data['currentPassword_err'] = "*invalid password";
                    }
                }else{
                    //user not found
                    // die("Something went wrong!!!");
                    $this->landToErrorPage();
                }

                // check weather new password and confirm password are equal or not
                if(strval($data["newPassword"]) == strval($data["confirmPassword"])){
                    //pass
                }else{
                    $data["confirmPassword_err"] = "*password doesn't match";
                }

                // check weather there are no errors
                if(empty($data['currentPassword_err']) && empty($data['confirmPassword_err'])){
                    
                    //allow to change password
                    if($this->ownerModel->ownerChangesHisPassword($data)){
                        $this->view('owners/ownerChangesHisPassword');
                        
                        // send email to the user
                        $userName = $_SESSION['user_fName'];
                        $userEmail = $_SESSION['user_email'];

                        $this->sendEmailToTheUserWhenPasswordChanged($userName,$userEmail);
                        echo "<script>
                                    Swal.fire(
                                        'Password changed successfully',
                                        'success'
                                    )
                            </script>";
                    }else{
                        // die('something went wrong');
                        $this->landToErrorPage();
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/ownerChangesHisPassword', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'email' => '',
                    'nic' => '',
                    // 'pNumber' => '',
                    // 'password' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'nic_err' => '',
                    // 'pNumber_err' => '',
                    // 'password_err' => '',

                ];
                //load the view
                $this->view('owners/ownerChangesHisPassword', $data);
            }
        }
      
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 6. ) Owner adds a new user to the system (addUserToTheSystem)
        public function addUserToTheSystem(){
            /**
             * There are,
             *      1.) Validate the form data -> done
             *      2.) Generate a password -> done
             *      3.) If there are no errors then add the user to the system -> done
             *      4.) Send an email to the user with the password -> done
            */

            // load the form
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // get the form data store in data variable
                $data = [
                    'fName' => trim($_POST['first_name']),
                    'lName' => trim($_POST['last_name']),
                    'email' => trim($_POST['email']),
                    'status' => trim($_POST['status']),
                    'nic' => trim($_POST['nic_number']),
                    'pNumber' => trim($_POST['contact_number']),
                    'userRole' => ucfirst(strtolower(trim($_POST['user_role']))),

                    'userPassword' => '', // this generate after confirmed entered details are ready.

                    'fName_err' => '',
                    'lName_err' => '',
                    'email_err' => '',
                    'status_err' => '',
                    'nic_err' => '',
                    'pNumber_err' => '',
                    'userRole_err' => ''
                ];

                //validate first name
                if(empty($data['fName'])){
                    $data['fName_err'] = '*enter first name';
                } 

                //validate last name
                if(empty($data['lName'])){
                    $data['lName_err'] = '*enter last name';
                }

                //validate email
                if(empty($data['email'])){
                    $data['email_err'] = '*enter email Number';
                }else{
                    //check weather email is availble in database
                    // true means that email is already taken.
                    if($this->ownerModel->findUserByEmail($data['email'])){
                        $data['email_err'] = "*email is already taken";
                    }else{
                        //pass
                    }
                }

                //validate NIC
                if(empty($data['nic'])){
                    $data['nic_err'] = '*enter NIC number';
                }elseif (!(strlen($input) == 12 && ctype_digit($input))) {
                    $data['nic_err'] = '*invalid NIC number';
                }
                else{
                    //check weather nic is availble in database
                    // true means that email is already taken.
                    if($this->ownerModel->findNicNumber($data['nic'])){
                        $data['nic_err'] = "*NIC is already taken";
                    }else{
                        //pass
                    }
                }

                //validate phone number
                if(empty($data['pNumber'])){
                    $data['pNumber_err'] = '*enter phone Number';
                }elseif (preg_match('/^0[0-9]{0,9}$/', $data['pNumber'])) {
                    $data['pNumber_err'] = '*invalid phone number';
                }
                else{
                    //check weather phone number is availble in database.
                    // true means that phone number is already taken.
                    if($this->ownerModel->findPhoneNumber($data['pNumber'])){
                        $data['pNumber_err'] = "*Phone Number is already taken";
                    }else{
                        //pass
                    }
                }

                // if there is no error then add the user to the system
                if(empty($data['fName_err']) && empty($data['lName_err']) && empty($data['email_err']) && empty($data['status_err'])  && empty($data['nic_err']) && empty($data['pNumber_err']) && empty($data['userRole_err'])){

                    // generate password -> calls generatePassword() function
                    $data['userPassword'] = $this->generatePassword();
                    // $data['userPassword'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    
                    // send email to the user -> calls sendEmailToTheUser() function                    
                    $this->sendEmailToTheUser($data['fName'] ,$data['email'], $data['userPassword']);

                    //sweet alert
                    echo "<script>
                                Swal.fire(
                                    'User added successfully',
                                    'success'
                                )
                        </script>";
                    // add user to the system
                    if($this->ownerModel->addUserIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        $this->view('owners/addUser');
                    }else{
                        // die('something went wrong');
                        $this->landToErrorPage();
                    }
                }else{
                    //load the view with errors
                    $this->view('owners/addUser', $data);
                }

            }else{
                // if request is not a POST request then load the form
                $data = [
                    'fName' => '',
                    'lName' => '',
                    'pNumber' => '',
                    'email' => '',
                    'password' => '',
                    'nic' => '',

                    'fName_err' => '',
                    'lName_err' => '',
                    'pNumber_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'nic_err' => '',

                ];
                $this->view('owners/addUser', $data);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 7. ) Owner handle administrator page (administrator)
        public function administrator(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */
            
            // load administrator's data
            $administratorsDetails = $this->ownerModel->getAdminDetails();
            $data = [
                'admin_details' => $administratorsDetails
            ];

            //view details
            $this->view('owners/administrator',$data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 8. ) Owner handle administrator search (search administrator)
        public function search_adminstrators(){

            $result = $this->ownerModel->search_adminstrators($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                    <td><input type="checkbox"></td>
                    <td>' . $row->firstName . " " . $row->lastName . '</td>
                    <td>' . $row->userID . '</td>
                    <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                    </td>
                    <td>' . $row->emailAdd . '</td>
                    <td>' . $row->NIC . '</td>
                    <td>' . $row->role . '</td>
                    <td>
                        <a href="'.URLROOT.'/owners/userProfileViewButton?userID='.$row->userID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                    </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 9. ) Owner handle mechanic page (mechanic)
        public function mechanic(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */

            // load mechanic's data
            $mechanicDetails = $this->ownerModel->getMechanicDetails();
            $data = [
                'mechanic_details' => $mechanicDetails
            ];

            //view details
            $this->view('owners/mechanic', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 10.) Owner handle mechanic search (search_mechanic)
        public function search_mechanics(){

            $result = $this->ownerModel->search_mechanics($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                    <td><input type="checkbox"></td>
                    <td>' . $row->firstName . " " . $row->lastName . '</td>
                    <td>' . $row->userID . '</td>
                    <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                    </td>
                    <td>' . $row->emailAdd . '</td>
                    <td>' . $row->NIC . '</td>
                    <td>' . $row->role . '</td>
                    <td>
                        <a href="'.URLROOT.'/owners/userProfileViewButton?userID='.$row->userID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                    </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }
        

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 11.) Owner handle rider page (riders)
        public function riders(){
            /**
             * There are,
             *      1.) Load the data 
             *      2.) View the data
            */

            // load rider's data
            $ridersDetails = $this->ownerModel->getRiderDetails();
            $data = [
                'rider_details' => $ridersDetails
            ];

            //view details
            $this->view('owners/riders', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 12.) Owner handle rider search (search_riders)
        public function search_riders(){

            $result = $this->ownerModel->search_riders($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                    <td><input type="checkbox"></td>
                    <td>' . $row->firstName . " " . $row->lastName . '</td>
                    <td>' . $row->userID . '</td>
                    <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                    </td>
                    <td>' . $row->emailAdd . '</td>
                    <td>' . $row->NIC . '</td>
                    <td>' . $row->role . '</td>
                    <td>
                        <a href="'.URLROOT.'/owners/userProfileViewButton?userID='.$row->userID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                    </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 13.) Owner handle bicycle owner page (bicycleOwner)
        public function bicycleOwner(){
            /**
             *     Tasks
             *          1.) Load the data 
             *          2.) View the data
            *  */ 

            // load owner's mechanic control
            //code will implement here
            $bikeOwnerDetails = $this->ownerModel->getbikeOwnerDetails();
            $data = [
                'bikeOwner_details' => $bikeOwnerDetails
            ];

            //view details
            $this->view('owners/bicycleOwner', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 14.) Owner handle bicycle owner search (search_bicycleOwners)
        public function search_bicycleOwners(){

            $result = $this->ownerModel->search_bicycleOwners($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                    <td><input type="checkbox"></td>
                    <td>' . $row->firstName . " " . $row->lastName . '</td>
                    <td>' . $row->userID . '</td>
                    <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                    </td>
                    <td>' . $row->emailAdd . '</td>
                    <td>' . $row->NIC . '</td>
                    <td>' . $row->role . '</td>
                    <td>
                        <a href="'.URLROOT.'/owners/userProfileViewButton?userID='.$row->userID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                    </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 15.) Owner handle repair log page (repairLog)
        public function repairLog(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
            */
            $this->landToErrorPage();
            // $this->view('owners/repairLog');
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 16.) Owner handle docking areas page (dockingAreas)
        public function dockingAreas(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
             *   
            */

            $dockingAreaDetails = $this->ownerModel->getDockingAreasDetails();

            $data = [
                'docking_areas_details' => $dockingAreaDetails
            ];

            $this->view('owners/dockingareas', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 17.) Owner handle docking areas search (search_dockingAreas)
        public function search_docking_areas(){

            $result = $this->ownerModel->search_docking_areas($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                        <td><input type="checkbox" name="selected[]" value="'.$row->areaID.'"></td>
                        <td>' . $row->areaID .  '</td>
                        <td>' . $row->areaName . '</td>
                        <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                    </td>
                        <td>'. round($row->locationLat,4) ."° N, ". round($row->locationLong,4) .'° E </td>
                        <td>' . $row->currentNoOfBikes . '</td>
                        <td>
                            <a href="'.URLROOT.'/owners/editDADetails?areaID='.$row->areaID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                        </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 18.) Add docking area to the system (addDockingAreaToSystem)
        public function addDockingAreaToSystem(){
            /**
             *  Task
             *      This function task is validate data from the addBikeOwner form and,
             *         1.) if data is valid then send data to insert into the system
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // process form
                //init data
                $data = [
                    'areaName' => trim($_POST['areaName']),
                    'locationLat' => trim($_POST['locationLat']),
                    'locationLong' => trim($_POST['locationLong']),
                    'locationRadius' => trim($_POST['locationRadius']),
                    'traditionalAdd' => trim($_POST['traditionalAdd']),
                    'status' => trim($_POST['status']),
                    'currentNoOfBikes' => trim($_POST['currentNoOfBikes']),

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',
                ];

                //validate submitted data
                if(empty($data['areaName'])){
                    $data['areaName_err'] = '*enter area name';
                }

                if(empty($data['locationLat'])){
                    $data['locationLat_err'] = '*enter location latitude';
                }

                if(empty($data['locationLong'])){
                    $data['locationLong_err'] = '*enter location longitude';
                }

                if(empty($data['locationRadius'])){
                    $data['locationRadius_err'] = '*enter location radius';
                }

                if(empty($data['traditionalAdd'])){
                    $data['traditionalAdd_err'] = '*enter traditional address';
                }

                if(empty($data['status'])){
                    $data['status_err'] = '*enter status';
                }

                if(empty($data['currentNoOfBikes'])){
                    $data['currentNoOfBikes'] = 0;
                }

                //make sure there are no errors
                if(empty($data['areaName_err']) && empty($data['locationLat_err']) && empty($data['locationLong_err']) && empty($data['locationRadius_err']) && empty($data['traditionalAdd_err']) && empty($data['status_err']) && empty($data['currentNoOfBikes_err'])){
                    //every things up to ready 

                    // add docking area
                    if($this->ownerModel->addDAIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/owners/dockingareas');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/owners/dockingareas');
                        //die('something went wrong!');
                    }
                }
                else{

                    $this->view('owners/addDockingArea', $data);
                }
            }else{
                //init data
                $data = [
                    'areaName' => '',
                    'locationLat' => '',
                    'locationLong' => '',
                    'locationRadius' => '',
                    'traditionalAdd' => '',
                    'status' => '',
                    'currentNoOfBikes' => '',

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',

                ];
                $this->view('owners/addDockingArea', $data);
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 19.) Delete Docking Areas selected (deleteDockingArea)
        public function deleteDAs(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $selectedRows = json_decode($_POST['selectedRows']);
                foreach($selectedRows as $selectedRow){
                    // echo $selectedRow." ";
                    $this->ownerModel->removeDA($selectedRow);
                }
                header('Location:'.URLROOT.'/owners/dockingareas');
            }else{
                die("button didn't work correctly.");
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 20.) Edit Docking Area Details (editDADetails)
        public function editDADetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'areaID' => intval(trim($_GET['areaID'])),
                    'areaDetailObject' => '',

                    'areaName' => '',
                    'locationLat' => '',
                    'locationLong' => '',
                    'locationRadius' => '',
                    'traditionalAdd' => '',
                    'status' => '',
                    'currentNoOfBikes' => '',

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',

                ];
                $data['areaDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findAreaByID($data['areaID']);
                $this->view('owners/viewAreaDetails', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'areaDetailObject' => '',
                    'areaID' => intval(trim($_POST['areaID'])),

                    'areaName' => trim($_POST['areaName']),
                    'locationLat' => trim($_POST['locationLat']),
                    'locationLong' => trim($_POST['locationLong']),
                    'locationRadius' => trim($_POST['locationRadius']),
                    'traditionalAdd' => trim($_POST['traditionalAdd']),
                    'status' => trim($_POST['status']),
                    'currentNoOfBikes' => trim($_POST['currentNoOfBikes']),

                    'areaName_err' => '',
                    'locationLat_err' => '',
                    'locationLong_err' => '',
                    'locationRadius_err' => '',
                    'traditionalAdd_err' => '',
                    'status_err' => '',
                    'currentNoOfBikes_err' => '',
                ];
                $data['areaDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findAreaByID($data['areaID']);

                //validate submitted data
                    if(empty($data['areaName'])){
                        $data['areaName_err'] = '*Area Name is Required';
                    }

                    if(empty($data['locationLat'])){
                        $data['locationLat_err'] = '*Latitude is Required';
                    }else if(!is_numeric($data['locationLat'])){
                        $data['locationLat_err'] = '*Latitude should be a number';
                    }else if($data['locationLat'] < 0){
                        $data['locationLat_err'] = '*Latitude should be a positive number';
                    }

                    if(empty($data['locationLong'])){
                        $data['locationLong_err'] = '*Longitude is Required';
                    }else if(!is_numeric($data['locationLong'])){
                        $data['locationLong_err'] = '*Longitude should be a number';
                    }else if($data['locationLong'] < 0){
                        $data['locationLong_err'] = '*Longitude should be a positive number';
                    }

                    if(empty($data['locationRadius'])){
                        $data['locationRadius_err'] = '*Location Radius is Required';
                    }else if(!is_numeric($data['locationRadius'])){
                        $data['locationRadius_err'] = '*Location Radius should be a number';
                    }else if($data['locationRadius'] < 0){
                        $data['locationRadius_err'] = '*Location Radius should be a positive number';
                    }

                    if(empty($data['traditionalAdd'])){
                        $data['traditionalAdd_err'] = '*Traditional Address is Required';
                    }

                    // if(empty($data['status'])){
                    //     $data['status_err'] = '*Status is Required';
                    // }

                    if(empty($data['currentNoOfBikes'])){
                        $data['currentNoOfBikes'] = 0;
                    }else if(!is_numeric($data['currentNoOfBikes'])){
                        $data['currentNoOfBikes_err'] = '*Current Number of Bikes should be a number';
                    }else if($data['currentNoOfBikes'] < 0){
                        $data['currentNoOfBikes_err'] = '*Current Number of Bikes should be a positive number';
                    }
                //
                

                if(empty($data['areaName_err']) && empty($data['locationLat_err']) && empty($data['locationLong_err']) && empty($data['locationRadius_err']) && empty($data['traditionalAdd_err']) && empty($data['status_err']) && empty($data['currentNoOfBikes_err'])){
                    //every things up to ready 

                    // update bike
                    if($this->ownerModel->updateDA($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/owners/dockingareas');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/owners/dockingareas');
                        // die('something went wrong!');
                    }
                }
                else{
                    // die($data['areaName_err'].$data['locationLat_err'].$data['locationLong_err'].$data['locationRadius_err'].$data['traditionalAdd_err'].$data['status_err'].$data['currentNoOfBikes_err']);
                    $this->view('owners/viewAreaDetails', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }

        

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 21.) Owner handle bicycle control page (bicyclesControl)
        public function bicyclesControl(){
            /**
             * There are,
             *      1.) Load the data
             *      2.) View the data
             *   
            */

            $bicyclesDetails = $this->ownerModel->getBicyclesDetails();

            $data = [
                'bicycles_details' => $bicyclesDetails
            ];

            $this->view('owners/bicycles', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 22.) Owner handle search bicycle (search_bicycles)
        public function search_bicycles(){

            $result = $this->ownerModel->search_bicycles($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                        <td><input type="checkbox" name="selected[]" value="'.$row->bicycleID.'"></td>
                        <td>' . $row->bicycleID .  '</td>
                        <td>' . $row->frameSize . '</td>
                        <td>';

                    $secondPart = ' ';

                    if ($row->status == 1) {
                        $secondPart .= "Active";
                    } elseif ($row->status == 0) {
                        $secondPart .= "Inactive";
                    } else {
                        $secondPart .= "Deleted";
                    }

                    $thirdPart = '
                        </td>
                        <td>' . $row->dateAcquired . '</td>
                        <td>' . $row->datePutInUse . '</td>
                        <td>' . $row->totalKM . '</td>
                        <td>' . ($row->currentLocationLat != NULL ? $row->currentLocationLat : "Null") . '</td>
                        <td>' . $row->bikeOwnerID . '</td>
                        <td>
                            <a href="'.URLROOT.'/owners/editDADetails?areID='.$row->bicycleID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                        </td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }


        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 23.) Add bicycle to the system (addBicycle)
        public function addBicycle(){
            /**
             *  Task
             *      This function task is validate data from the addbike form and,
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
                    if($this->ownerModel->addBicycleIntoTheSystem($data)){
                        // next implementation should be land into the right position according to the role
                        // $this->bicyclesControl();
                        header('Location:'.URLROOT.'/owners/bicyclesControl');
                    }else{
                        die('something went wrong');
                    }
                }
                else{
                    $this->view('owners/addBicycle', $data);
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
                $this->view('owners/addBicycle', $data);
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 24.) Delete Bike selected (deleteBicycles)
        public function deleteBicycles(){
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $selectedRows = json_decode($_POST['selectedRows']);
                
                foreach($selectedRows as $selectedRow){
                    // echo $selectedRow." ";
                    $this->ownerModel->removeBicycle($selectedRow);
                }
                header('Location:'.URLROOT.'/owners/bicyclesControl');
            }else{
                die("button didn't work correctly.");
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 25.) Edit bicycle (editBicycleDetails)
        public function editBicycleDetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
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
                $data['bicycleDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findBicycleByID($data['bicycleID']);
                $this->view('owners/viewBicycleDetails', $data);

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
                $data['bicycleDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findBicycleByID($data['bicycleID']);
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
                    if($this->ownerModel->updateBicycle($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/owners/bicyclesControl');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/owners/bicyclesControl');
                        //die('something went wrong!');
                    }
                }
                else{
                    $this->view('owners/viewBicycleDetails', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }



        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 26.) Owner handle rides control page (ridesControl)
        public function ridesControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */

            // load rides data
            $ridesDetails = $this->ownerModel->getRidesDetails();

            $data = [
                'rides_details' => $ridesDetails
            ];

            //this is not load data from the database
            $this->view('owners/rides', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 27.) Rides search (search_rides)
        public function search_rides(){

            $result = $this->ownerModel->search_rides($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                        <td></td>
                        <td>' . $row->riderID .  '</td>
                        <td>' . $row->bicycleID . '</td>
                        <td>' . $row->startAreaID . '</td>
                        <td>' . $row->endAreaID . '</td>
                        <td>' . $row->rideStartTimeStamp . '</td>
                        <td>';

                    $secondPart = ' ';

                    if ($row->rideEndTimeStamp == NULL) {
                        $secondPart .= "Active";
                    }else {
                        $secondPart .= $row->rideEndTimeStamp;
                    }

                    $thirdPart = '
                        </td>
                        <td>' . $row->distanceTravelled . '</td>
                        <td>' . $row->fare . '</td>
                    </tr>';

                    $output .= $firstPart . $secondPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 28.) Owner handle reports control page (reportsControl)
        public function reportsControl(){
            /**
             * There are,
             *     1.) Load the data
             *    2.) View the data
            */

            $reportDetails = $this->ownerModel->getReportDetails();
            $data = [
                'reports_details' => $reportDetails
            ];

            $this->view('owners/reports', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 29.) Reports search (search_reports)
        public function search_reports(){

            $result = $this->ownerModel->search_reports($_POST['search']);
            $output = '';

            if($result>0){
                foreach($result as $row){

                    $firstPart = '
                    <tr style="height: 2.5rem;">
                        <td><input type="checkbox" name="selected[]" value="'.$row->reportID.'"></td>
                        <td>' . $row->reportID .  '</td>
                        <td>' . $row->reporterID .  '</td>
                        <td>' . $row->status .  '</td>
                        <td>' . $row->problemTitle .  '</td>
                        <td>' . ($row->assignedMechanic != null ? $row->assignedMechanic : "Null") . '</td>
                        <td>' . $row->loggedTimestamp . '</td>
                        <td>' . $row->reportType . '</td>
                        ';

                    $thirdPart = '
                    </td>
                        <td>
                            <a href="'.URLROOT.'/owners/editReportDetails?reportID='.$row->reportID.'"><img src="'.URLROOT.'/public/images/owners/editIconsViewIcons/editIcon1.png" alt="edit"></a>
                        </td>
                    </tr>';

                    $output .= $firstPart . $thirdPart;
                }
            }else{
                $output .= '<tr>
                                <td>No Data Found</td>
                            </tr>';
            }

            echo $output;
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 30.) Owner handle edit report details page (editReportDetails)
        public function editReportDetails(){
            /**
             *  Task one load the user detail button
            */
            //die("halp");
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'reportID' => intval(trim($_GET['reportID'])),
                    'reportDetailObject' => '',

                    'mechanicID' => '',
                    'mechanicID_err' => '',
                ];
                $data['reportDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findReportByID($data['reportID']);
                $this->view('owners/viewReport', $data);

            }else if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'reportDetailObject' => '',
                    
                    'reportID' => intval(trim($_POST['reportID'])),
                    'mechanicID' => trim($_POST['mechanicID']),
                    'mechanicID_err' => '',
                ];
                $data['reportDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findReportByID($data['reportID']);
                
                //validate submitted data
                    //validate mechanic ID
                    if(empty($data['mechanicID'])){
                        $data['mechanicID_err'] = '*Mechanic ID is Required';
                    }else if(!is_numeric($data['mechanicID'])){
                        $data['mechanicID_err'] = '*Mechanic ID must be a number';
                    }else if($data['mechanicID'] < 0){
                        $data['mechanicID_err'] = '*Mechanic ID must be a positive number';
                    }
                //

                if(empty($data['mechanicID_err'])){
                    //every things up to ready 

                    // update bike
                    if($this->ownerModel->assignReportMechanic($data)){
                        // next implementation should be land into the right position according to the role
                        header('Location:'.URLROOT.'/owners/reportsControl');
                    }else{
                        //have an issue where, even if you don't update anything and click update, the above if returns false
                        header('Location:'.URLROOT.'/owners/reportsControl');
                        //die('something went wrong!');
                    }
                }
                else{
                    $this->view('owners/viewReport', $data);
                }

            }else{
                die("button didn't work correctly.");
            }       
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 31.)archived reports (archivedReports)
        public function archiveReports(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $selectedRows = json_decode($_POST['selectedRows']);
                
                foreach($selectedRows as $selectedRow){
                    // echo $selectedRow." ";
                    $this->ownerModel->removeReport($selectedRow);
                }
                header('Location:'.URLROOT.'/owners/reportsControl');
            }else{
                die("button didn't work correctly.");
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 32.) unarchive reports (unarchiveReports)
        public function unarchiveReports(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $selectedRows = json_decode($_POST['selectedRows']);
                
                foreach($selectedRows as $selectedRow){
                    // echo $selectedRow." ";
                    $this->ownerModel->unarchiveReport($selectedRow);
                }
                header('Location:'.URLROOT.'/owners/archivedReportsControl');
            }else{
                die("button didn't work correctly.");
            }
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 33.) Owner handle archived reports page (archivedReportsControl)
        public function archivedReportsControl(){

            $reportDetails = $this->ownerModel->getArchivedReportDetails();
            $data = [
                'reports_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('owners/archievedReports', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 34.) Owner handle accident reports page (AccidentReportsControl)
        public function AccidentReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->ownerModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('owners/reportsAccident', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 35.) Owner handle bicycle reports page (BicycleReportsControl)
        public function BicycleReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->ownerModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('owners/reportsBike', $data);
        }

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 36.) Owner handle DA reports page (DAReportsControl)
        public function DAReportsControl(){
            /**
             * Task 
             *      1.) handle repair in the system
             *      2.) View the data
            *  */ 
        
            // load admin's repairlog control
            //code will implement here
            $reportDetails = $this->ownerModel->getReportDetails();
            $data = [
                'report_details' => $reportDetails
            ];

            //this is not load data from the data
            $this->view('owners/reportsDA', $data);
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 37.) (inbuilt) Generate password length 8
        private function generatePassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }


        //////////////////////////////////////////////////////////////////////////////////////////////////
        // 38.) (inbuilt) Send email to the user
        private function sendEmailToTheUser($userName, $userEmail , $userPassword){

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = 'true';
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($userEmail);

            $mail->isHTML(true);


            $mail->Subject = 'Access to ' . APPLICATION_NAME;
            $mail->Body = '
            <html>
            <head>
              <title>Access to '. APPLICATION_NAME .'</title>
              <style>
                body {
                  font-family: Arial, sans-serif;
                  font-size: 14px;
                }
                h1 {
                  font-size: 18px;
                  color: #444;
                  margin-bottom: 20px;
                }
                ul {
                  list-style-type: none;
                  padding: 0;
                  margin: 0;
                }
                li {
                  margin-bottom: 10px;
                }
              </style>
            </head>
            <body>
              <h1>Access to '.APPLICATION_NAME.'</h1>
              <p>Dear ' . $userName . ',</p>
              <p>Greetings!</p>
              <p>We are pleased to inform you that you have been added to <b>'.APPLICATION_NAME.'</b>.</p>
              <p>Your account has been created and you can now access our platform by logging in with the following credentials:</p>
              <ul>
                <li><b>Email:</b> ' . $userEmail . '</li>
                <li><b>Password:</b> ' . $userPassword . '</li>
              </ul>
              <p>Please note that for security purposes, we strongly advise you to change your password after your first login.</p>
              <p>Thank you for choosing <b>'.APPLICATION_NAME.'</b>. If you have any questions or need assistance, please don\'t hesitate to contact us.</p>
              <p>Best regards,<br>
              '.APPLICATION_NAME.'</p>
            </body>
            </html>
            '
            ;

            $mail->send();
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////
        // 39) (inbuilt) Send email to the user when current password is changed
        private function sendEmailToTheUserWhenPasswordChanged($userName, $userEmail){

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = 'true';
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($userEmail);

            $mail->isHTML(true);

            $mail->Subject = 'Password Changed for ' . APPLICATION_NAME;
            $mail->Body = '            
                    <html>
                    <head>
                    <title>Password Changed for '. APPLICATION_NAME .'</title>
                    <style>
                        body {
                        font-family: Arial, sans-serif;
                        font-size: 14px;
                        }
                        h1 {
                        font-size: 18px;
                        color: #444;
                        margin-bottom: 20px;
                        }
                        ul {
                        list-style-type: none;
                        padding: 0;
                        margin: 0;
                        }
                        li {
                        margin-bottom: 10px;
                        }
                    </style>
                    </head>
                    <body>
                    <h1>Password Changed for '.APPLICATION_NAME.'</h1>
                    <br>
                    <p>Dear '. $userName .',</p>
                    <p>We wanted to let you know that your password for '.APPLICATION_NAME.' has been changed.<br> If you did not request this change, please contact our support team immediately at <a href="mailto:support@bikable.com">'.APPEMAIL.'</a>.</p>
                    <p>If you did change your password, you can ignore this message.</p>
                    <br>
                    <p>Thank you for using BIKABLE.</p>
                    <p>Best regards,<br>The '.APPLICATION_NAME.' Team</p>
                    </body>
                    </html>'
                ;
            
            $mail->send();
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 40.) (inbuilt) land to the error page
        public function landToErrorPage(){
            //load the error page only view
            $this->view('users/error');
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 41.) user profile view button (userProfileViewButton)
        public function userProfileViewButton(){
            // get the user id from the form
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                $data = [
                    'userID' => intval(trim($_GET['userID'])),
                    'userDetailObject' => ''
                ];
                //get the user details from the database
                $data['userDetailObject'] = $prespectiveUserDetail = $this->ownerModel->findUserByUserID($data['userID']);
                
                //load the user profile view page
                $this->view('owners/ownerViewsUserProfile', $data);
            }else{
                // die("button didn't work correctly.");
                $this->landToErrorPage();
            }            
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 42.) suspend and release user (suspendReleaseUser)
        public function suspendReleaseUser(){

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'userIdentity' => intval(trim($_POST['userIdentity'])),
                    'userStatus' => intval(trim($_POST['userStatus']))
                ];
                
                //suspend the user and release the user
                if($data['userStatus'] == 1){
                    $isUserSuspend = $this->ownerModel->suspendUserByUserID($data['userIdentity']);
                    if($isUserSuspend){
                        //land to the administrator page
                        $this->administrator();
                    }else{
                        // die("some thing went wrong at the suspend process");
                        $this->landToErrorPage();
                    }
                }elseif ($data['userStatus'] == 0) {
                    $isUserRelease = $this->ownerModel->activateUserByUserID($data['userIdentity']);
                    if($isUserRelease){
                        //land to the administrator page
                        $this->administrator();
                    }else{
                        // die("some thing went wrong at the suspend process");
                        $this->landToErrorPage();
                    }
                }else{
                    // die("some thing went wrong at the suspend process");
                    $this->landToErrorPage();
                }
            }else{
                // die("some thing went wrong at the suspend process");
                $this->landToErrorPage();
            }   
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 43.) Statistics
        public function statisticsPageView(){
            /**
             * There are,
             *      1.) Load the data
             *     2.) View the data 
            */

            //get total riders from the database
            $totalRiders = $this->ownerModel->getTotalRiders();
            $riderCount = $totalRiders->{'COUNT(*)'};

            //get total bikes from the database
            $totalBikes = $this->ownerModel->getTotalBicycles();
            $bikeCount = $totalBikes->{'COUNT(*)'};

            //get total docking areas from the database
            $totalDockingAreas = $this->ownerModel->getTotalDockingAreas();
            $dockingAreaCount = $totalDockingAreas->{'COUNT(*)'};

            //get active reports from the database
            $activeReports = $this->ownerModel->getActiveReports();
            $activeReportCount = $activeReports->{'COUNT(*)'};

            //get fare and rate value from the database
            $fareAndRate = $this->ownerModel->getFareAndRate();
            $fare = $fareAndRate->{'baseValue'};
            $rate = $fareAndRate->{'ratePer10'};

            //////////////////////////////////////////////////////////////////////////////////////////
            //get seven days latest
            $xDate = $this->ownerModel->getlatestSevenDays();

            $dateTest = array();
            foreach ($xDate as $y) {
                $dateTest[] = $y->date;
            }
            // print_r($dateTest);
            // print"<br>";
            // die("fuck");

            // print_r($this->ownerModel->bikeReportsCount($x[0]->date)->bicycle_count);
            // die("fuck2");

            $bikeReport = array();
            $accidentReport = array();
            $areaReport = array();

            foreach ($xDate as $y) {
                $bikeReport[] = $this->ownerModel->bikeReportsCount($y->date)->bicycle_count;
                $accidentReport[] = $this->ownerModel->accidentReport($y->date)->accident_count;
                $areaReport[] = $this->ownerModel->areaReportsCount($y->date)->area_count;
            }

            //////////////////////////////////////////////////////////////////////////////////////////
            // get adminstrators count
            // these two values are object OKAY
            $administratorCount = $this->ownerModel->getAdministratorCount();
            $mechanicsCount = $this->ownerModel->getMechanicsCount();

            $data = [
                'totalRiders' => $riderCount,
                'totalBikes' => $bikeCount,
                'totalDockingAreas' => $dockingAreaCount,
                'activeReports' => $activeReportCount,
                'fare' => $fare,
                'rate' => $rate,
                'xDate' => $dateTest,
                'bikeReports' => $bikeReport,
                'accidentReports' => $accidentReport,
                'areaReports' => $areaReport,
                'administratorCount' => $administratorCount->count,
                'mechanicsCount' => $mechanicsCount->count
            ];
            
            $this->view('owners/statistics', $data);
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // 44.) Set fare and rate
        public function setFareAndRate(){
            /**
             * There are,
             *      1.) Insert data into the database
             *     
            */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $data = [
                    'fareValue' => floatval(trim($_POST['fare'])),
                    'rateValue' => floatval(trim($_POST['rate']))
                ];
                //get the user details from the database
                if($this->ownerModel->setFareAndRate($data)){
                    //load the user profile view page

                    //popup message
                    $this->statisticsPageView();
                    echo "<script>
                        Swal.fire(
                            'Changed successfully',
                            'Fare and rate changed successfully',
                        )
                    </script>";
                }else{
                    // die("button didn't work correctly.");
                    $this->landToErrorPage();
                }
            }else{
                // die("button didn't work correctly.");
                $this->landToErrorPage();
            }  
        }


        ///////////////////////////////////////////////////////////////////////////////////////////////////////////
        // (Inbuild) account suspention email
        private function sendAccountSuspensionEmail($userName, $userEmail){
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($userEmail);

            $mail->isHTML(true);

            $mail->Subject = 'Account Suspension Notification';
            $mail->Body = '
                <html>
                <head>
                    <title>Account Suspension Notification</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                        }
                        h1 {
                            font-size: 18px;
                            color: #444;
                            margin-bottom: 20px;
                        }
                        ul {
                            list-style-type: none;
                            padding: 0;
                            margin: 0;
                        }
                        li {
                            margin-bottom: 10px;
                        }
                    </style>
                </head>
                <body>
                    <h1>Account Suspension Notification</h1>
                    <p>Dear ' . $userName . ',</p>
                    <p>We regret to inform you that your account has been temporarily suspended on ' . APPLICATION_NAME . '.</p>
                    <p>Please contact our support team for further assistance regarding the suspension.</p>
                    <p>Thank you for your understanding and cooperation.</p>
                    <p>Best regards,<br>
                    ' . APPLICATION_NAME . '</p>
                </body>
                </html>
            ';

            $mail->send();
        }

        public function sendAccountReleaseEmail($userName, $userEmail){
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = APPEMAIL;
            $mail->Password = PASSWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom(APPEMAIL);
            $mail->addAddress($userEmail);

            $mail->isHTML(true);

            $mail->Subject = 'Account Release Notification';
            $mail->Body = '
                <html>
                <head>
                    <title>Account Release Notification</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            font-size: 14px;
                        }
                        h1 {
                            font-size: 18px;
                            color: #444;
                            margin-bottom: 20px;
                        }
                        ul {
                            list-style-type: none;
                            padding: 0;
                            margin: 0;
                        }
                        li {
                            margin-bottom: 10px;
                        }
                    </style>
                </head>
                <body>
                    <h1>Account Release Notification</h1>
                    <p>Dear ' . $userName . ',</p>
                    <p>We are pleased to inform you that your account on ' . APPLICATION_NAME . ' has been released.</p>
                    <p>You can now access our platform using your previously provided credentials.</p>
                    <p>If you have any questions or need further assistance, please don\'t hesitate to contact us.</p>
                    <p>Thank you for using ' . APPLICATION_NAME . '.</p>
                    <p>Best regards,<br>
                    ' . APPLICATION_NAME . '</p>
                </body>
                </html>
            ';

            $mail->send();
        }




}