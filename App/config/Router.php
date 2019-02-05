<?php

namespace App\config;

class Router
{

    public function run($twig){

        $page = 'home';
        if (isset($_GET['p'])){
            $page = $_GET['p'];
        }

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
    }
}