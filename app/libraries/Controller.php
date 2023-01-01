<?php
    /**
     *         PARENT CONTROLLER HANDLE 2 THINGS
     *              1.) DATABASE (MODEL)
     *              2.) VIEW
     */
    class Controller{
        
        //load model
        public function model($model){
            require_once('../app/models/' . $model . '.php');

            //run that model class
            return new $model;
        }

        //load view
        public function view($view, $data = []){
            if(file_exists('../app/views/' . $view . '.php')){
                require_once('../app/views/' . $view . '.php');
            }else{
                die('view does not exist.');
            }
        }
    }