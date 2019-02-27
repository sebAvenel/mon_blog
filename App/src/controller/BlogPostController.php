<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;

/**
 * Class BlogPostController
 * @package App\src\controller
 */
class BlogPostController extends Controller
{
    private $blogPostDAO;
    private $commentsDAO;
    private $sessionArray;

    /**
     * BlogPostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentsDAO = new CommentsDAO();
        $this->sessionArray = array('addCommentSuccess', 'errorUpdateComment', 'successUpdateComment', 'errorAddComment');
    }

    /**
     * Displays the view that contains the list of blog posts
     */
    public function blogPostsList()
    {
        echo $this->getTwig->render('frontOffice/blogPostsList.twig', [
            'blogPostsList' => $this->blogPostDAO->getBlogPosts()
        ]);
    }

    /**
     * Displays the view that contains a blog post with comments
     *
     * @param int $idBlogPost
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function blogPostWithComments($idBlogPost)
    {
        $this->sessionCleaner($this->sessionArray);
        echo $this->getTwig->render('frontOffice/blogPostWithComments.twig', [
            'blogPost' => $this->blogPostDAO->getBlogPost($idBlogPost),
            'comments' => $this->commentsDAO->getCommentsFromBlogPost($idBlogPost)
        ]);
    }

}

