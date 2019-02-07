<?php

require '../config/dev.php';
require '../config/Autoloader.php';
require '../../vendor/autoload.php';
/*require '../config/Router.php';*/
config\Autoloader::register();

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, [
    'cache' => false, // __DIR__ . 'tmp'
]);

$router = new \App\config\Router();
$router->run($twig);

/*
$frontcontroller = new \App\src\controller\FrontController();
var_dump($frontcontroller->getBlogPost(2));


$frontcontroller = new \App\src\controller\FrontController();
var_dump($frontcontroller->listOfComments(2));
*/