<?php

namespace App\config;

use \App\src\controller\FrontController;

class Router
{

    private $frontController;

    public function __construct()
    {
        $this->frontController = new FrontController();
    }

    public function run($twig){

        $page = 'home';
        if (isset($_GET['route'])){
            $page = $_GET['route'];
        }

        if (isset($_GET['idBlogPost'])){
            $idBlogPost = $_GET['idBlogPost'];
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
            case 'blogPostWithComments':
                echo $twig->render('blogPostWithComments.twig');
                break;
            case 'blogPostsList':
                echo $twig->render('blogPostsList.twig', [
                    'blogPostsList' => $this->frontController->listOfBlogPosts()
                ]);
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                echo $twig->render('404.twig');
                break;
        }
    }
}