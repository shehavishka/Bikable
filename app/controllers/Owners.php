<?php 
    class Owners extends Controller{
        // owner connect to the database
        private $ownerModel;

        public function __construct(){
            $this->ownerModel = $this->model('Owner');
        }

        
    }