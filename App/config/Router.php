<?php

namespace App\config;

use App\src\controller\BlogPostController;
use App\src\controller\CommentController;
use App\src\controller\HomeController;
use App\src\controller\UserController;

/**
 * Class Router
 * @package App\config
 */
class Router
{
    private $homeController;
    private $blogPostController;
    private $userController;
    private $commentController;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->homeController = new HomeController();
        $this->blogPostController = new BlogPostController();
        $this->userController = new UserController();
        $this->commentController = new CommentController();
    }

    /**
     * Routing
     */
    public function run(){

        $page = 'home';
        if (isset($_GET['route']))
        {
            $page = $_GET['route'];
        }

        switch ($page)
        {
            case 'home':
                $this->homeController->homePage();
                break;
            case 'homeContact':
                $this->homeController->sendmail($_POST['sendMailName'], $_POST['sendMailEmail'], $_POST['sendMailPhone'], $_POST['sendMailMessage']);
                break;
            case 'blogPostsList':
                $this->blogPostController->blogPostsList();
                break;
            case 'blogPostWithComments':
                $this->blogPostController->blogPostWithComments($_GET['idBlogPost']);
                break;
            case 'signIn':
                if (isset($_POST['signInEmail']) && isset($_POST['signInPassword'])){
                    $this->userController->authUser($_POST['signInEmail'], $_POST['signInPassword'], $_POST['signInCheckbox']);
                }else{
                    $this->homeController->signInPage();
                }
                break;
            case 'disconnection':
                $this->userController->disconnectUser();
                break;
            case 'updateComment':
                $this->commentController->updateComment($_GET['idComment'], $_POST['textareaModifComment'], $_GET['idBlogPost']);
                break;
            case 'deleteComment':
                $this->commentController->deleteComment($_GET['idComment'], $_GET['idBlogPost']);
                break;
            case 'addComment':
                $this->commentController->addComment($_POST['textareaAddComment'], $_GET['idBlogPost'], $_GET['idUser']);
                break;
            case 'forgotPassword':
                $this->homeController->forgotPasswordPage();
            default:
                break;
        }
    }
}