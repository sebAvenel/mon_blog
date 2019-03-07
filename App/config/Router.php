<?php

namespace App\config;

use App\src\controller\AdminController;
use App\src\controller\BlogPostController;
use App\src\controller\CommentController;
use App\src\controller\Controller;
use App\src\controller\HomeController;
use App\src\controller\UserController;

/**
 * Class Router
 * @package App\config
 */
class Router
{
    private $controller;
    private $homeController;
    private $blogPostController;
    private $userController;
    private $commentController;
    private $adminController;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->controller = new Controller();
        $this->homeController = new HomeController();
        $this->blogPostController = new BlogPostController();
        $this->userController = new UserController();
        $this->commentController = new CommentController();
        $this->adminController = new AdminController();
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
                } else {
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
                if (isset($_GET['email']) && isset($_POST['inputUpdatePassword']) && isset($_POST['inputConfirmUpdatePassword'])){
                    $this->userController->updatePassword($_GET['email'], $_POST['inputUpdatePassword'], $_POST['inputConfirmUpdatePassword']);
                } elseif (isset($_GET['emailUpdatePassword']) && isset($_GET['keyActivateUpdatePassword'])){
                    $this->userController->updateForgotPasswordPage($_GET['emailUpdatePassword'], $_GET['keyActivateUpdatePassword']);
                } elseif (isset($_POST['inputEmailForgotPassword'])){
                    $this->userController->sendmailForgotPassword($_POST['inputEmailForgotPassword']);
                } else {
                    $this->homeController->forgotPasswordPage();
                }
                break;
            case 'registerUser':
                if (isset($_POST['inputRegisterUserName']) && isset($_POST['inputRegisterUserMail']) && isset($_POST['inputRegisterUserPassword']) && isset($_POST['inputRegisterUserPasswordConfirm'])){
                    $this->userController->sendmailRegisterUser($_POST['inputRegisterUserName'], $_POST['inputRegisterUserMail'], $_POST['inputRegisterUserPassword'], $_POST['inputRegisterUserPasswordConfirm']);
                } elseif (isset($_GET['emailActivationUserAccount']) && isset($_GET['keyActivationUserAccount'])){
                    $this->userController->userActivationAccount($_GET['emailActivationUserAccount'], $_GET['keyActivationUserAccount']);
                } else {
                    $this->homeController->registerPage();
                }
                break;
            case 'adminBlogPosts':
                $this->adminController->blogPostsAdminPage();
                break;
            case 'adminComments':
                $this->adminController->commentsAdminPage();
                break;
            case 'adminProfiles':
                $this->adminController->profilesAdminPage();
                break;
            default:
                $this->controller->errorViewDisplay('Erreur 404, page introuvable');
                break;
        }
    }
}
