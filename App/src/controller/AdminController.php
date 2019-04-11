<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;
use App\src\DAO\UserDAO;
use App\src\service\Sanitize;

/**
 * Class AdminController
 * @package App\src\controller
 */
class AdminController extends Controller
{
    private $blogPostsDAO;
    private $commentsDAO;
    private $userDAO;

    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPostsDAO = new BlogPostDAO();
        $this->commentsDAO = new CommentsDAO();
        $this->userDAO = new UserDAO();
    }

    /**
     * Display the blog posts administration page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function blogPostsAdminPage()
    {
        echo $this->twig->render('admin/blogPostsAdmin.twig', [
            'blogPostsList' => $this->blogPostsDAO->getAll(0, $this->blogPostsDAO->count())
        ]);

        return;
    }

    /**
     * Display the comments administration page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function commentsAdminPage()
    {
        $idBlogPost = Sanitize::onInteger('get', 'idBlogPostCommentsAdmin') ?? null;
        echo $this->twig->render('admin/commentsAdmin.twig', [
            'blogPostsList' => $this->blogPostsDAO->getAll(0, $this->blogPostsDAO->count()),
            'uniqueBlogPost' => $this->blogPostsDAO->getOneById($idBlogPost),
            'invalidComments' => $this->commentsDAO->getInvalidComments($idBlogPost)
        ]);

        return;
    }

    /**
     * Display the profiles administration page
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function profilesAdminPage()
    {
        echo $this->twig->render('admin/profilesAdmin.twig', [
            'userList' => $this->userDAO->getUsers()
        ]);

        return;
    }
}
