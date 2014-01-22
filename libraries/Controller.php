<?php

class Controller {

    function __construct() {
        $this->view = new View();
    }
    
    /**
     * Loads the model file and initiates it for the controller to use it.
     * 
     * @param string $name of the model
     * @param string $modelPath the path of the models folder
     */
    public function loadModel($name, $modelPath = 'models/') {
        $path = $modelPath . $name.'_model.php';
        
        if (file_exists($path)) {
            require $modelPath .$name.'_model.php';
            
            $modelName = $name . '_Model';
            $this->model = new $modelName();
        }        
    }
}