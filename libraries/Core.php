<?php

class Core {

    private $_url = null;
    private $_controller = null;
    
    //Path to controllers and models folders
    private $_controllerPath = 'controllers/';
    private $_modelPath = 'models/';
    
    // Default controllers
    private $_errorController = 'error';
    private $_defaultController = 'bookmarks';
    

    /**
     * Starts the Core class.
     * it will load the controller on the URL or the default controller if no URL is set
     */
    public function init() {

        // Sets the protected $_url
        $this->_getUrl();

        // Load the default controller if no URL is set
        if (empty($this->_url[1])) {
            $this->_loadDefaultController();
        }else{
            $this->_loadExistingController();
            $this->_callControllerMethod();
        }

        // includes the flash messages to the application
        include 'Flash.php';
    }
    

    /**
     * Gets the $_GET from the URL
     */
    private function _getUrl() {
        $url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }
    

    /**
     * This will load if there is no GET parameter passed and will load the default controller
     */
    private function _loadDefaultController() {
        require $this->_controllerPath . $this->_defaultController . '.php';
        $this->_controller = new $this->_defaultController;
        $this->_controller->loadModel($this->_defaultController, $this->_modelPath);
        $this->_controller->index();
    }
    

    /**
     * This will load an existing controller if there IS a GET parameter passed.
     */
    private function _loadExistingController() {
        $file = $this->_controllerPath . $this->_url[1] . '.php';
        
        if (file_exists($file)) {
            require $file;
            $this->_controller = new $this->_url[1];
            $this->_controller->loadModel($this->_url[1], $this->_modelPath);
        } else {
            $this->_error();
        }
    }
    

    /**
     * This will check if a method is passed in the GET url paremter
     * 
     *  http://site/controller/method/(param)/(param)/(param)
     *  url[1] = Controller
     *  url[2] = Method
     *  url[3] = Param
     *  url[4] = Param
     *  url[5] = Param
     */
    private function _callControllerMethod() {
        $length = count($this->_url);

        // Make sure the method we are calling exists
        if ($length > 2) {
            if (!method_exists($this->_controller, $this->_url[2])) {
                $this->_error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 6:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[2]}($this->_url[3], $this->_url[4], $this->_url[5]);
                break;
            case 5:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[2]}($this->_url[3], $this->_url[4]);
                break;
            case 4:
                //Controller->Method(Param1)
                $this->_controller->{$this->_url[2]}($this->_url[3]);
                break;
            case 3:
                //Controller->Method()
                $this->_controller->{$this->_url[2]}();
                break;
            default:
                $this->_controller->index();
                break;
        }
    }


    /**
     * Redirects the browser to the specified controller.
     * @param string $controller to be redirected to. Note that when controller is not
     * absolute (not starting with "/").
     * @param boolean $terminate whether to terminate the current application
     * @param integer $statusCode the HTTP status code. Defaults to 302. See {@link http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html}
     * for details about HTTP status code.
     */
    public static function redirect($controller,$terminate=true,$statusCode=302) {
        header('Location: /'.$controller, true, $statusCode);
        exit;
    }


    /**
     * Refreshes the browser to the last page visited. 
     * Its for when updating and wanting to go to last page instead of a new one. 
     */
    public static function refreshLast() {
        $page = $_SERVER['HTTP_REFERER'];
        $sec = "0";
        header("Refresh: $sec; url=$page");
    }


    /**
     * Display an error page if nothing exists
     */
    private function _error() {
        require $this->_controllerPath . $this->_errorController . '.php';
        $this->_controller = new Error();
        $this->_controller->index();
        exit;
    }

}