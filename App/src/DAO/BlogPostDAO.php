<?php

namespace App\src\DAO;

use src\model\BlogPost;


class BlogPostDAO extends DAO
{
    public function getBlogPosts(){
        $sql = 'SELECT id, title, chapo, content, created_at, updated_at, id_user FROM blog_post ORDER BY id DESC';
        $result = $this->sql($sql);
        $blogPosts = [];
        foreach ($result as $row){
            $blogPostId = $row['id'];
            $blogPosts[$blogPostId] = $this->buildObjectBlogPost($row);
        }
    }

    private function buildObjectBlogPost(array $row)
    {
        $article = new BlogPost();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setChapo($row['chapo']);
        $article->setContent($row['content']);
        $article->setCreatedAt($row['created_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setIdUser($row['id_user']);
        return $article;
    }
}