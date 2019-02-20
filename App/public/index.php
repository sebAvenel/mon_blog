<?php

require '../../vendor/autoload.php';

// Router

$page = 'home';
if (isset($_GET['p'])){
    $page = $_GET['p'];
}

// Loader twig

$loader = new Twig_Loader_Filesystem('../templates');
$twig = new Twig_Environment($loader, [
    'cache' => false, // __DIR__ . 'tmp'
]);

switch ($page){
    case 'home':
        echo $twig->render('home.twig');
        break;
    case 'signin':
        echo $twig->render('signIn.twig');
        break;
    case 'register':
        echo $twig->render('register.twig');
        break;
    case 'forgotPassword':
        echo $twig->render('forgotPassword.twig');
        break;
    default:
        header('HTTP/1.0 404 Not Found');
        echo $twig->render('404.twig');
        break;
}