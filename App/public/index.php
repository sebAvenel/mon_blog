<?php

require '../config/dev.php';
require '../../vendor/autoload.php';
require '../config/Router.php';

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, [
    'cache' => false, // __DIR__ . 'tmp'
]);

$router = new \App\config\Router();
$router->run($twig);




