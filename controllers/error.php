<?php

class Error extends Controller {

    public function __construct() {
        parent::__construct(); 
    }

    /**
     * Shows the 404 error page
     */
    public function index() {
        $data['title'] = '404 Error';
        $this->view->render('error/404', $data);
    }
}