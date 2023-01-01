<?php
    /**
     *  @Title  : Bikable 
     *  @Author : Shehaan Avishka
     *  Data    : Nov 29 2022
    */

    // load configuration files
    require_once('config/config.php');

    // this session_helper file helps to create sessions in the web application ( keep user details)
    require_once('helper/session_helper.php');

    //this url_helper file helps to redirect through the application.
    require_once('helper/url_helper.php');

    /**
     *  In the MVC stands for,
     *      M -> Model
     *      V -> View
     *      C -> Control
     *  When application starts, all Controller,Core,Database files requires to be activate. To do that use following 
     *  function.This function requires all Library files (Controller.php / Core.php / Database.php)
     * 
     *  */ 
    spl_autoload_register(function($className){
        require_once('libraries/' . $className . '.php');
    });