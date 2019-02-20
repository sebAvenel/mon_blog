<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;

class BlogPostController extends TwigController
{
    private $blogPostDAO;
    private $commentsDAO;

    public function __construct()
    {
        parent::__construct();
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentsDAO = new CommentsDAO();
    }

    public function blogPostsList()
    {
        echo $this->getTwig->render('frontOffice/blogPostsList.twig', [
            'blogPostsList' => $this->blogPostDAO->getBlogPosts()
        ]);
    }

    public function blogPostWithComments($idBlogPost)
    {
        if (isset($_SESSION['addCommentSuccess'])){
            unset($_SESSION['addCommentSuccess']);
        }
        echo $this->getTwig->render('frontOffice/blogPostWithComments.twig', [
            'blogPost' => $this->blogPostDAO->getBlogPost($idBlogPost),
            'comments' => $this->commentsDAO->getCommentsFromBlogPost($idBlogPost)
        ]);
    }

}