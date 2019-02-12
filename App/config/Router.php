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

        $idBlogPost = (int) '';
        if (isset($_GET['idBlogPost'])){
            $idBlogPost = $_GET['idBlogPost'];
        }

        $errors = [];
        if (isset($_SESSION['errors'])){
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        $success = '';
        if (isset($_SESSION['success'])){
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $inputs = [];
        if (isset($_SESSION['inputs'])){
            $inputs = $_SESSION['inputs'];
            unset($_SESSION['inputs']);
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
                echo $twig->render('blogPostWithComments.twig', [
                    'blogPost' => $this->frontController->getBlogPost($idBlogPost),
                    'comments' => $this->frontController->listOfCommentsWithUser($idBlogPost)
                ]);
                break;
            case 'homeContact':
                echo $twig->render('home.twig', [
                    'errors' => $errors,
                    'success' => $success,
                    'inputs' => $inputs
                ]);
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