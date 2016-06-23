<?php
// Sets the path of the app directory
defined('APP_PATH')
    || define('APP_PATH', realpath(dirname(__FILE__) . '/../app'));

// Directory name public
define('PUBLIC_FOLDER', basename(__DIR__));

// It includes general settings
require_once APP_PATH . '/config/config.php';

// It includes classes and register to the autoload
require_once APP_PATH . '/../vendor/Ever/Autoload/Autoload.php';
\Ever\Autoload\Autoload::autoloadRegister();

// Startup Class Instance
$init = new App\Init;
// Run the application
$init->run();