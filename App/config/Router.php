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

    const ROUTE_LIST = ['home', 'homeContact', 'blogPostsList', 'blogPostWithComments', 'signIn', 'signInUser', 'disconnection', 'updateComment',
        'deleteComment', 'addComment', 'forgotPassword', 'updatePassword', 'updatePasswordPage', 'sendmailForgotPassword', 'registerUser', 'sendmailRegisterUser',
        'confirmRegisterUser', 'adminBlogPosts', 'updateBlogPosts', 'addBlogPosts', 'deleteBlogPosts', 'adminComments', 'adminCommentsCheck', 'validComments', 'deleteCommentsByAdmin',
        'adminProfiles', 'deleteProfiles', 'changeRoleProfiles'];

    const ROUTE_INFORMATION = ['home' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'homePage'],
        'homeContact' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'sendmail'],
        'blogPostsList' => ['get' => [], 'post' => [], 'controller' => 'blogPost', 'method' => 'blogPostsList'],
        'blogPostWithComments' => ['get' => ['idBlogPost'], 'post' => [], 'controller' => 'blogPost', 'method' => 'blogPostWithComments'],
        'signIn' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'signInPage'],
        'signInUser' => ['get' => [], 'post' => ['signInEmail', 'signInPassword'], 'controller' => 'user', 'method' => 'authUser'],
        'disconnection' => ['get' => [], 'post' => [], 'controller' => 'user', 'method' => 'disconnectUser'],
        'updateComment' => ['get' => ['idComment', 'idBlogPost', 'token'], 'post' => [], 'controller' => 'comment', 'method' => 'updateComment'],
        'deleteComment' => ['get' => ['idComment', 'idBlogPost', 'token'], 'post' => [], 'controller' => 'comment', 'method' => 'deleteCommentByUser'],
        'addComment' => ['get' => ['idBlogPost', 'idUser', 'token'], 'post' => [], 'controller' => 'comment', 'method' => 'addComment'],
        'forgotPassword' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'forgotPasswordPage'],
        'updatePassword' => ['get' => ['email'], 'post' => ['inputUpdatePassword', 'inputConfirmUpdatePassword'], 'controller' => 'user', 'method' => 'updatePassword'],
        'updatePasswordPage' => ['get' => ['keyActivateUpdatePassword'], 'post' => [], 'controller' => 'user', 'method' => 'updatePasswordPage'],
        'sendmailForgotPassword' => ['get' => [], 'post' => ['inputEmailForgotPassword'], 'controller' => 'user', 'method' => 'sendmailForgotPassword'],
        'registerUser' => ['get' => [], 'post' => [], 'controller' => 'home', 'method' => 'registerPage'],
        'sendmailRegisterUser' => ['get' => [], 'post' => ['inputRegisterUserName', 'inputRegisterUserMail', 'inputRegisterUserPassword', 'inputRegisterUserPasswordConfirm'], 'controller' => 'user', 'method' => 'sendmailRegisterUser'],
        'confirmRegisterUser' => ['get' => ['keyActivationUserAccount'], 'post' => [], 'controller' => 'user', 'method' => 'userActivationAccount'],
        'adminBlogPosts' => ['get' => [], 'post' => [], 'controller' => 'admin', 'method' => 'blogPostsAdminPage'],
        'updateBlogPosts' => ['get' => ['updateBlogPost', 'token'], 'post' => ['inputAdminBlogPostTitle', 'inputAdminBlogPostChapo', 'inputAdminBlogPostContent', 'id'], 'controller' => 'blogPost', 'method' => 'updateBlogPost'],
        'addBlogPosts' => ['get' => ['addBlogPost', 'token'], 'post' => ['inputAdminBlogPostTitle', 'inputAdminBlogPostChapo', 'inputAdminBlogPostContent'], 'controller' => 'blogPost', 'method' => 'addBlogPost'],
        'deleteBlogPosts' => ['get' => ['token'], 'post' => ['idBlogPostDeleted'], 'controller' => 'blogPost', 'method' => 'deleteBlogPost'],
        'adminComments' => ['get' => [], 'post' => [], 'controller' => 'admin', 'method' => 'commentsAdminPage'],
        'adminCommentsCheck' => ['get' => ['idBlogPostCommentsAdmin'], 'post' => [], 'controller' => 'admin', 'method' => 'commentsAdminCheck'],
        'validComments' => ['get' => ['idBlogPost', 'idValidComment', 'token'], 'post' => [], 'controller' => 'comment', 'method' => 'validComment'],
        'deleteCommentsByAdmin' => ['get' => ['idBlogPost', 'idDeleteComment', 'token'], 'post' => [], 'controller' => 'comment', 'method' => 'deleteCommentByAdmin'],
        'adminProfiles' => ['get' => [], 'post' => [], 'controller' => 'admin', 'method' => 'profilesAdminPage'],
        'deleteProfiles' => ['get' => ['token'], 'post' => ['idDeleteUser'], 'controller' => 'user', 'method' => 'deleteUser'],
        'changeRoleProfiles' => ['get' => ['idUser', 'roleUser', 'token'], 'post' => [], 'controller' => 'user', 'method' => 'changeRoleUser']
    ];

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

        $route = self::ROUTE_INFORMATION[$page] ?? [];
        if (!in_array($page, self::ROUTE_LIST)
            || (!empty($route['get']) && !$this->checkGet($route['get']))
            || (!empty($route['post']) && !$this->checkPost($route['post']))
            || !$this->getMethod($this->getController($route['controller']), $route['method'])
        ) {
            try {
                echo $this->controller->errorViewDisplay('Une erreur s\'est produite lors du routing');

                return false;
            } catch (\Exception $e) {
                return false;
            }
        }

        $controller = $this->getController($route['controller']);
        $method = $this->getMethod($controller, $route['method']);

        return $this->$controller->$method();
    }

    /**
     * Check if Controller exists
     *
     * @param $name
     * @return bool|string
     */
    private function getController(string $name)
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
    private function getMethod(string $class, string $method)
    {
        if (method_exists('\App\src\controller\\' . $class, $method)) {
            return $method;
        }

        return false;
    }

    /**
     * Check $_GET array
     *
     * @param array $getList
     * @return bool
     */
    private function checkGet(array $getList): bool
    {
        foreach ($getList as $value) {
            if (isset($_GET[$value])){
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
    private function checkPost(array $getPost): bool
    {
        foreach ($getPost as $value) {
            if (isset($_POST[$value])){
                continue;
            }

            return false;
        }

        return true;
    }
}
