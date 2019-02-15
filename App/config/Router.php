<?php

namespace App\config;

use \App\src\controller\FrontController;
use \App\src\controller\BackController;

class Router
{

    private $frontController;
    private $BackController;

    public function __construct()
    {
        $this->frontController = new FrontController();
        $this->BackController = new BackController();
    }

    public function run($twig){

        $page = 'home';
        if (isset($_GET['route']))
        {
            $page = $_GET['route'];
        }

        $idBlogPost = (int) '';
        if (isset($_GET['idBlogPost']))
        {
            $idBlogPost = $_GET['idBlogPost'];
        }

        $errors = [];
        if (isset($_SESSION['errors']))
        {
            $errors = $_SESSION['errors'];
            unset($_SESSION['errors']);
        }

        $success = '';
        if (isset($_SESSION['success']))
        {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }

        $inputs = [];
        if (isset($_SESSION['inputs']))
        {
            $inputs = $_SESSION['inputs'];
            unset($_SESSION['inputs']);
        }

        $connectUser = [];
        if (isset($_POST['signInEmail']) && isset($_POST['signInPassword']))
        {
            $this->BackController->authUser($_POST['signInEmail'], $_POST['signInPassword']);
            if (isset($_SESSION['infosUser']))
            {
                header('Location: ../public/index.php');
            }
        }

        if (isset($_SESSION['errorAuthUser']))
        {
            $connectUser = $_SESSION['errorAuthUser'];
            unset($_SESSION['errorAuthUser']);
            $page = 'signin';
        }

        if (isset($_SESSION['infosUser']))
        {
            $connectUser = $_SESSION['infosUser'];
        }

        if (isset($_GET['deconnexion']))
        {
            session_destroy();
            header('Location: ../public/index.php');
        }

        switch ($page)
        {
            case 'home':
                echo $twig->render('home.twig', [
                    'userConnectSuccess' => $connectUser
                ]);
                break;
            case 'signin':
                echo $twig->render('signIn.twig', [
                    'errorConnectUser' => $connectUser
                ]);
                break;
            case 'register':
                echo $twig->render('register.twig', [
                    'userConnectSuccess' => $connectUser
                ]);
                break;
            case 'forgotPassword':
                echo $twig->render('forgotPassword.twig');
                break;
            case 'blogPostWithComments':
                echo $twig->render('blogPostWithComments.twig', [
                    'blogPost' => $this->frontController->getBlogPost($idBlogPost),
                    'comments' => $this->frontController->listOfCommentsWithUser($idBlogPost),
                    'userConnectSuccess' => $connectUser
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
                    'blogPostsList' => $this->frontController->listOfBlogPosts(),
                    'userConnectSuccess' => $connectUser
                ]);
                break;
            default:
                header('HTTP/1.0 404 Not Found');
                echo $twig->render('404.twig');
                break;
        }
    }
}