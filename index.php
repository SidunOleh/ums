<?php

use Components\Router;

// error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

// autoloader
require_once 'Components/autoload.php';

// routing
$router   = new Router();
$response = $router->run();

// send response
echo $response;
