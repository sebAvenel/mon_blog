<?php

require '../../vendor/autoload.php';
require '../config/dev.php-dist';

session_start();

$router = new \App\config\Router();
$router->run();