<?php
// loads the config file to be used in the application
require 'config/main.php';

// It autoloads the libraries
function __autoload($class) {
    require "libraries/" . $class .".php";
}

// initiate the application
$core = new Core();
$core->init();