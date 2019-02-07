<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;

class FrontController
{
    private $blogPostDAO;
    private $commentDAO;

    public function __construct()
    {
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentDAO = new CommentsDAO();
    }

    public function listOfBlogPosts()
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        return $blogPosts;
    }

    public function getBlogPost($idBlogPost)
    {
        $blogPost = $this->blogPostDAO->getBlogPost($idBlogPost);
        return $blogPost;
    }

    public function listOfComments($idBlogPost)
    {
        $comments = $this->commentDAO->getCommentsFromBlogPost($idBlogPost);
        return $comments;
    }
}