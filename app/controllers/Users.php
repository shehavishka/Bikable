<?php
    /**
     *   Application brain default focus on this USERS CLASS
     *   
     *   TASKS:
     *      i.) LOGIN
     *      ii.) RESET PASSWORD
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
                $this->view('users/login', $data);
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
            $_SESSION['user_first_name'] = $user->first_name;
            $_SESSION['user_last_name'] = $user->last_name;
            $_SESSION['user_role'] = $user->role;

            //redirect to the user's(owners) home
            // die("logged successfully");
            // $this->view('owners/ownerLandPage');
            redirect('owners/ownerLandPage');
        }

        ////////////////////////////
        // SEND EMAIL TO THE USER
        ////////////////////////////
        public function sendEmailToUser($email){
            //code will be implement heref

        }

    }