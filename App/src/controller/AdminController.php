<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;
use App\src\DAO\UserDAO;

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
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function blogPostsAdminPage()
    {
        echo $this->Twig->render('admin/blogPostsAdmin.twig', [
            'blogPostsList' => $this->blogPostsDAO->getBlogPosts()
        ]);
    }

    /**
     * Display the comments administration page
     *
     * @param null $idBlogPost
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function commentsAdminPage($idBlogPost = null)
    {
        echo $this->Twig->render('admin/commentsAdmin.twig', [
            'blogPostsList' => $this->blogPostsDAO->getBlogPosts(),
            'uniqueBlogPost' => $this->blogPostsDAO->getBlogPost($idBlogPost),
            'invalidComments' => $this->commentsDAO->getInvalidComments($idBlogPost)
        ]);
    }

    /**
     * Display the profiles administration page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function profilesAdminPage()
    {
        echo $this->Twig->render('admin/profilesAdmin.twig', [
            'userList' => $this->userDAO->getUsers()
        ]);
    }
}
