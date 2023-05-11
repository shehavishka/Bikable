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
            if($passwd == $userPassword){
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
    }