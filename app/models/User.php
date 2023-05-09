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


        public function login($userEmail, $userPassword){
            $this->db->prepareQuery("SELECT * FROM users where emailAdd = '$userEmail'");

            $row = $this->db->single();

            // there is a another method to unhashed the values;
            $passwd = $row->password;

            if(password_verify(strval($userPassword),($passwd))){
                $this->updateLoggedInTime($userEmail);
                return $row;
            }else{
                return false;
            }
        }

        public function updateLoggedInTime($userEmail){

            $this->db->prepareQuery("UPDATE users SET lastLoggedIn = CURRENT_TIMESTAMP WHERE emailAdd = '$userEmail' ");

            $row = $this->db->single();

            if($this->db->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }
    }