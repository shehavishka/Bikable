<?php 
    class User {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function findUserByEmail($userEmail){
            $this->db->prepareQuery("SELECT * FROM users where emailAdd = '$userEmail'");
            // $this->db->bind(':email', $userEmail);

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function findyears($years){
            $this->db->prepareQuery("SELECT * FROM users where years = '$years'");

            $this->db->single();

            //check row
            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }

        public function findPhoneNumber($userPNumber){
            $this->db->prepareQuery("SELECT * FROM users where phoneNumber = '$userPNumber'");

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
            $years=$data['years'];
            $stripeID = $data['stripe_customer_id'];

            // Hash the password
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            // Check if the user already exists
            $this->db->prepareQuery("SELECT * FROM users WHERE emailAdd = '$email'");
            $row = $this->db->single();
        
            if ($row) {
                // User already exists, return false or throw an error
                return false;
            } else {
                // Insert new user into the database
                $temp = "INSERT INTO users (years , firstName , lastName , phoneNumber , role , status , password , emailAdd, stripeID) 
                VALUES ('$years', '$first_name', '$last_name', '$phone_no', 'Rider', '0', '$password', '$email', '$stripeID')";
                //echo $temp;
                $this->db->prepareQuery($temp);

                if($this->db->executeStmt()){
                    // Signup successful
                    return true;
                }else{
                    // Signup failed, return false
                    return false;
                }
            }
        }

        public function otp($email,$otp){
           
            $temp = "INSERT INTO emailOTP (email , OTP) VALUES ('$email' , '$otp')";
            $this->db->prepareQuery($temp);
            return $this->db->executeStmt();

        }

        //we prepare a new function to get riding years from the database
        public function Ridingyears($email){
            //die($email);
            $this->db->prepareQuery("SELECT * FROM users WHERE email = '$email'");
            $row = $this->db->single();
            $Dbyears = $row->years;
            
            

            if($Dbyears > '5'){
                console.log('exp');
                return true;

            }else{
                return false;
                
            }



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
                return true;

            }else{
                return false;
                
            }
        }
    }