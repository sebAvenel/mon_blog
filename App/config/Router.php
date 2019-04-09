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

        $routesList = ['home', 'homeContact', 'blogPostsList', 'blogPostWithComments', 'signIn', 'disconnection', 'updateComment',
            'deleteComment', 'addComment', 'forgotPassword', 'registerUser', 'adminBlogPosts', 'adminComments', 'adminProfiles'];

        $routesInformation = ['home' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'homePage'],
            'homeContact' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'sendmail'],
            'blogPostsList' => ['get' => [], 'post' => [], 'controller' => 'blogPost', 'method' => 'blogPostList'],
            'blogPostWithComments' => ['get' => ['idBlogPost'], 'post' => [], 'controller' => 'home', 'method' => 'sendmail'],
        ];

        if (in_array($page, $routesList)) {
            $route = $routesInformation[$page];
            if (!empty($route['get'])) {
                if (!$this->checkGet($route['get'])) {
                    return $this->controller->errorViewDisplay('Une erreur s\'est produite');
                }
            }

            if (!empty($route['post'])) {
                if (!$this->checkPost($route['post'])) {
                    return $this->controller->errorViewDisplay('Une erreur s\'est produite');
                }
            }

            if ($this->getController($route['controller'])) {
                $getController = $this->getController($route['controller']);
            } else {
                return $this->controller->errorViewDisplay('Une erreur s\'est produite');
            }

            if ($this->getMethod($getController, $route['method'])) {
                $getMethod = $this->getMethod($getController, $route['method']);
            } else {
                return $this->controller->errorViewDisplay('Une erreur s\'est produite');
            }

            echo $getController . '<br>';
            echo $getMethod;
            return $this->$getController->$getMethod;

        } else {
            return $this->controller->errorViewDisplay('Erreur 404, page introuvable');
        }
    }

        /*
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
    }*/

    /**
     * Check if Controller exists
     *
     * @param $name
     * @return bool|string
     */
    public function getController(string $name)
    {
        if (class_exists('App\src\controller\\' . ucfirst($name) . 'Controller')) {
            return $name . 'Controller';
        }

        return false;
    }

    /**
     * Check if method exist in controller
     *
     * @param string $class
     * @param string $method
     * @return bool|string
     */
    public function getMethod(string $class, string $method)
    {
        if (method_exists('\App\src\controller\\' . $class, $method)){
            return $method . '()';
        }

        return false;
    }

    /**
     * Check $_GET array
     *
     * @param array $getList
     * @return bool
     */
    public function checkGet(array $getList) :bool
    {
        foreach ($getList as $value){
            if ($_GET[$value]){
                continue;
            }

            return false;
        }

        return true;
    }

    /**
     * Check $_POST array
     *
     * @param array $getPost
     * @return bool
     */
    public function checkPost(array $getPost) :bool
    {
        foreach ($getPost as $value){
            if ($_POST[$value]){
                continue;
            }

            return false;
        }

        return true;
    }
}
