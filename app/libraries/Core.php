<?php
    /**
     *  This is the brain of the Application
     *  CORE class.
     * 
     *  Task:
     *      Grab the URL and filter,
     *          1.) Controller
     *          2.) Method
     *          3.) Parameters 
     */

    class Core{
        /**
         *  when application start, brain should be focus on default URL
         *      i.) current controller (default focus on Users Controller)
         *      ii.) method is login 
         */
        protected $currentController = "Users";
        protected $currentMethod = "login";
        protected $params = [];

        //Counstructor
        public function __construct(){
            // Application Start get the URL and trim and put in to the array ( [controller] [method] [parameters] )
            $url = $this->getUrl();

            /**
             *      CHECK CONTROLLER IN THE URL
             */
            if(isset($url[0])){
                if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                    $this->currentController = ucwords($url[0]);
                }
            }

            // Import update currentController
            require_once('../app/controllers/' . $this->currentController . '.php');

            //instatiate the class
            $this->currentController = new $this->currentController;

            // unset the first value from the url array
            unset($url[0]);     

            /**
             *      CHECK METHOD IN THE URL
             */
            if(isset($url[0])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //get the parameters in the url
            $this->params = $url ? array_values($url) : [];

            /**
             * After check the CONTROLLER,METHOD and PARAMETERS call that in method and send parameters to
             * that method.
             */
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
            
        }

        /**
         *  GET URL FROM THE WEB BROWSER AND TRIM AND PUT INTO THE ARRAY.
         */
        public function getUrl(){
            if(isset($_GET['url'])){
              $url = rtrim($_GET['url'], '/');
              $url = filter_var($url, FILTER_SANITIZE_URL);
              $url = explode('/', $url);
              return $url;
            }
          }
        
    }