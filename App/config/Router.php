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
    public function run()
    {
        $page = 'home';
        if (isset($_GET['route'])) {
            $page = $_GET['route'];
        }
        switch ($page) {
            case 'home':
                return $this->homeController->homePage();
            case 'homeContact':
                return $this->homeController->sendmail();
            case 'blogPostsList':
                return $this->blogPostController->blogPostsList();
            case 'blogPostWithComments':
                return $this->blogPostController->blogPostWithComments($_GET['idBlogPost']);
            case 'signIn':
                if (isset($_POST['signInEmail']) && isset($_POST['signInPassword'])) {
                    return $this->userController->authUser($_POST['signInEmail'], $_POST['signInPassword']);
                }

                return $this->homeController->signInPage();
            case 'disconnection':
                return $this->userController->disconnectUser();
            case 'updateComment':
                return $this->commentController->updateComment($_GET['idComment'], $_GET['idBlogPost']);
            case 'deleteComment':
                return $this->commentController->deleteCommentByUser($_GET['idComment'], $_GET['idBlogPost']);
            case 'addComment':
                return $this->commentController->addComment($_GET['idBlogPost'], $_GET['idUser']);
            case 'forgotPassword':
                if (isset($_GET['email']) && isset($_POST['inputUpdatePassword']) && isset($_POST['inputConfirmUpdatePassword'])) {
                    return $this->userController->updatePassword($_GET['email']);
                }

                if (isset($_GET['keyActivateUpdatePassword'])) {
                    return $this->userController->updateForgotPasswordPage($_GET['keyActivateUpdatePassword']);
                }

                if (isset($_POST['inputEmailForgotPassword'])) {
                    return $this->userController->sendmailForgotPassword($_POST['inputEmailForgotPassword']);
                }

                return $this->homeController->forgotPasswordPage();
            case 'registerUser':
                if (isset($_POST['inputRegisterUserName']) && isset($_POST['inputRegisterUserMail']) && isset($_POST['inputRegisterUserPassword']) && isset($_POST['inputRegisterUserPasswordConfirm'])) {
                    return $this->userController->sendmailRegisterUser();
                }

                if (isset($_GET['keyActivationUserAccount'])) {
                    return $this->userController->userActivationAccount($_GET['keyActivationUserAccount']);
                }

                return $this->homeController->registerPage();
            case 'adminBlogPosts':
                if (isset($_POST['inputAdminBlogPostTitle']) && isset($_POST['inputAdminBlogPostChapo']) && isset($_POST['inputAdminBlogPostContent'])) {
                    if (isset($_POST['id']) && isset($_GET['updateBlogPost'])) {
                        return $this->blogPostController->updateBlogPost((int) $_POST['id']);
                    }

                    if (isset($_GET['addBlogPost'])) {
                        return $this->blogPostController->addBlogPost();
                    }
                }

                if (isset($_POST['idBlogPostDeleted'])) {
                    $this->blogPostController->deleteBlogPost($_POST['idBlogPostDeleted']);
                }

                return $this->adminController->blogPostsAdminPage();
            case 'adminComments':
                if (isset($_GET['idBlogPost'])) {
                    if (isset($_GET['idValidComment'])) {
                        return $this->commentController->validComment($_GET['idValidComment'], $_GET['idBlogPost']);
                    }

                    if (isset($_GET['idDeleteComment'])) {
                        return $this->commentController->deleteCommentByAdmin($_GET['idDeleteComment'], $_GET['idBlogPost']);
                    }
                }

                return $this->adminController->commentsAdminPage($_GET['idBlogPostCommentsAdmin'] ?? null);
            case 'adminProfiles':
                if (isset($_GET['idUser']) && isset($_GET['roleUser'])) {
                    return $this->userController->changeRoleUser($_GET['roleUser'], $_GET['idUser']);
                }

                if (isset($_POST['idDeleteUser'])) {
                    return $this->userController->deleteUser($_POST['idDeleteUser']);
                }

                return $this->adminController->profilesAdminPage();
            default:
                return $this->controller->errorViewDisplay('Erreur 404, page introuvable');
        }
    }
}
