<?php

namespace App\src\controller;

use App\src\DAO\BlogPostDAO;

class FrontController
{
    private $blogPostDAO;

    public function __construct()
    {
        $this->blogPostDAO = new BlogPostDAO();
    }

    public function listOfBlogPosts()
    {
        $blogPosts = $this->blogPostDAO->getBlogPosts();
        return $blogPosts;
    }
}