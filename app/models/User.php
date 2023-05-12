<?php 
    class User {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function findUserByEmail($userEmail){
            $this->db->prepareQuery("SELECT * FROM users where emailAdd = '$userEmail' AND status = 0");
            // $this->db->bind(':email', $userEmail);

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }


        public function login($userEmail, $userPassword){
            $this->db->prepareQuery("SELECT * FROM users where emailAdd = '$userEmail'");

            $row = $this->db->single();

            // there is a another method to unhashed the values;
            $passwd = $row->password;

            if(password_verify(strval($userPassword),($passwd))){
                // $this->updateLoggedInTime($userEmail);
                return $row;
            }else{
                return false;
            }
        }

        public function updateLastLoggedIn($userID, $lastLoggedIn){
            $this->db->prepareQuery("UPDATE users SET lastLoggedIn = '$lastLoggedIn' WHERE userID = '$userID'");
            
            if($this->db->executeStmt()){
                return true;
            }else{
                return false;
            }
        }

        public function signup($data){
            $first_name=$data['first name'];
            $last_name=$data['last name'];
            $email=$data['email'];
            $password=$data['password'];
            $phone_no=$data['phone no'];
            $nic_no=$data['nic no'];


            // Check if the user already exists
            $this->db->prepareQuery("SELECT * FROM users WHERE emailAdd = '$email'");
            $row = $this->db->single();
        
            if ($row) {
                // User already exists, return false or throw an error
                return false;
            } else {
                // User does not exist, proceed with signup
                // Generate OTP
                //$otp = generateOTP();
        
                
                // Insert new user into the database
                $temp = "INSERT INTO users (NIC , firstName , lastName , phoneNumber , role , status , password , emailAdd ) 
                VALUES ('$nic_no', '$first_name', '$last_name', '$phone_no', 'Rider', '1', '$password', '$email')";
                $this->db->prepareQuery($temp);

                $this->db->executeStmt();

                if (true) {
                    // Signup successful, return the user data
                    $user = [
                        'emailAdd' => $email,
                        'password' => $password,
                        'firstName' => $first_name,
                        'lastName' => $last_name,
                        'phoneNumber' => $phone_no,
                        'NIC' => $nic_no,
                    ];
                    return $user;
                } else {
                    // Signup failed, return false or throw an error
                    return false;
                }
            }
        }

        public function otp($email,$otp){
           
            $temp = "INSERT INTO emailOTP (email , OTP) VALUES ('$email' , '$otp')";
            $this->db->prepareQuery($temp);
            return $this->db->executeStmt();

        }

        public function checkOTP($email,$otp){
            //die('checkOTP called');
            //get values from database where email is the same as the user input
            
            $this->db->prepareQuery("SELECT * FROM emailOTP WHERE email = '$email'");
            $row = $this->db->single();

            //get otp attribubte from row
            $DbOTP = $row->OTP;
            
            //check if user input is equal to the OTP
            if($otp == $DbOTP){
                //if OTP is correct, then register the user
                if(true){
                    echo("User registered successfully");
                    //if user is registered successfully, then redirect to login page
                    redirect('riders/riderLandPage');
                    
                }else{
                    echo("Something went wrong");
                }
            }else{
                //if OTP is incorrect, then redirect to signup page
                redirect('users/login');
                
            }
        }
    }