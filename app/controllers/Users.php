<?php
    /**
     *   Application brain default focus on this USERS CLASS
     *   
     *   TASKS:
     *      i.) LOGIN
     *      ii)RESET PASSWORD
     *        
    */

    /**
     *  If Authentication is succesfull then need to send an email to the user
     *  to do that have to USE some files from the  helper/PHPMailer directory
    */

    class Users extends Controller{
        /////////////////
        // CREATE VARIABLE TO CONNECT TO THE DATABASE
        ////////////////
        private $userModel;


        ///////////////
        // assigned 'User' model file
        //////////////
        public function __construct(){
            $this->userModel = $this->model('User');            
        }


        //////////////
        // USER'S LOGIN AUTHENTICATION
        /////////////
        public function login(){
            /**
             *  LOGIN AUTHENTICATION
             */
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                // grab data from the requested form
                $data = [
                    'email' => trim($_POST['userEmail']),
                    'password' => trim($_POST['userPassword']),

                    'email_err' => '',
                    'password_err' => '',

                ];

                ///////////////
                //  VALIDATE EMAIL AND PASSWORD
                ///////////////
                if(empty($data['email'])){
                    $data['email_err'] = ' *please enter email';
                }else{
                    //check user/email
                    if($this->userModel->findUserByEmail($data['email'])){
                        //user found
                    }else{
                        $data['email_err'] = "*user not found";
                    }
                }

                // valid password
                if(empty($data['password'])){
                    $data['password_err'] = ' *please enter password';
                }

                
                ///////////////
                // IF ERRORS FREE, THEN ACCORDING TO USER ROLE NEED TO CREATE SEASSION AND
                // LAND IN TO HIS/HER OWNS PAGE
                //////////////
                if(empty($data['email_err']) && empty($data['password_err'])){
                    ///////////////
                    // AUTHENTICATE USER'S EMAIL AND PASSWORD
                    ///////////////
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        /////////////////////
                        //SEND EMAIL
                        ////////////////////
                        // $this->sendEmailToUser($data['email']);

                        
                        /////////////////
                        // CHECK USER ROLE AND CREATE A SESSION
                        /////////////////
                        $this->createUserSession($loggedInUser);
                       
                    }else{
                        $data['password_err'] = '*incorrect password';
                        $this->view('users/login',$data);
                    }
                }else{
                    $this->view('users/login', $data);
                }


            }else{
                /**
                 *     If request is not POST then this scope will be execute.
                 */
                $data = [
                    'email' => '',
                    'password' => '',

                    'email_err' => '',
                    'password_err' => '',

                ];

                // if already logged in, redirect to the user's home
                if(isset($_SESSION['user_ID'])){
                    if(ucwords($_SESSION['user_role']) == 'Owner')
                    {
                        redirect('owners/ownerLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Administrator')
                    {
                        redirect('admins/adminLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Mechanic')
                    {
                        redirect('mechanics/mechanicLandPage');
                    }
                    else if(ucwords($_SESSION['user_role']) == 'Rider')
                    {
                        redirect('riders/riderLandPage');
                    }
                }else{
                    $this->view('users/login', $data);
                }
            }
        }



        //////////////////////
        // USER'S RESET PASSWORD
        // *need to implement in future
        /////////////////////



        ///////////////////////
        //  CREATE SESSION
        ///////////////////////
        public function createUserSession($user){
            //store session data
            $_SESSION['user_ID'] = $user->userID;
            $_SESSION['user_picture'] = $user->userPicture;
            $_SESSION['user_NIC'] = $user->NIC;
            $_SESSION['user_fName'] = $user->firstName;
            $_SESSION['user_lName'] = $user->lastName;
            $_SESSION['user_pNumber'] = $user->phoneNumber;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_status'] = $user->status;
            $_SESSION['user_email'] = $user->emailAdd;
            $_SESSION['user_registered_date'] = $user->registeredDate;

            // get current timestamp
            $lastLoggedIn = date('Y-m-d H:i:s');
            $_SESSION['user_last_logged_in'] = $lastLoggedIn;

            // update last logged in time
            $this->userModel->updateLastLoggedIn($user->userID, $lastLoggedIn);

            //redirect to the user's(owners) home
            // die("logged successfully");
            // $this->view('owners/ownerLandPage');
            if(ucwords($user->role) == 'Owner')
            {
                redirect('owners/ownerLandPage');
            }
            else if(ucwords($user->role) == 'Administrator')
            {
                redirect('admins/adminLandPage');
            }
            else if(ucwords($user->role) == 'Mechanic')
            {
                redirect('mechanics/mechanicLandPage');
            }
            else if(ucwords($user->role) == 'Rider')
            {
                redirect('riders/riderLandPage');
            }
            //redirect('owners/ownerLandPage');
        }

        ///////////////////////////////////
        // LOG OUT 
        //////////////////////////////////
        public function logout(){
            // DESTROY USER DETAILS
            unset($_SESSION['user_ID']);
            unset($_SESSION['user_picture']);
            unset($_SESSION['user_NIC']);
            unset($_SESSION['user_fName']);
            unset($_SESSION['user_lName']);
            unset($_SESSION['user_pNumber']);
            unset($_SESSION['user_role']);
            unset($_SESSION['user_status']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_registered_date']);
            unset($_SESSION['user_last_logged_in']);

            session_destroy();
            redirect('users/login');
        }

        ////////////////////////////
        // SEND EMAIL TO THE USER
        ////////////////////////////
        public function sendEmailToUser($email){
            //code will be implement heref

        }

    }