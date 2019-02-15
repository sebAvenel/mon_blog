<?php

namespace App\src\DAO;

use App\src\model\BlogPost;


class BlogPostDAO extends DAO
{
    public function getBlogPosts()
    {
        $sql = 'SELECT id, title, chapo, content, DATE_FORMAT(createdAt, "%d/%m/%Y") AS createdAt, updatedAt, idUser FROM blog_post ORDER BY id DESC';
        $result = $this->sql($sql);
        $blogPosts = [];
        foreach ($result as $row){
            $blogPostId = $row['id'];
            $blogPosts[$blogPostId] = $this->buildObjectBlogPost($row);
        }

        return $blogPosts;
    }

    public function getBlogPost($idBlogPost)
    {
        $sql = 'SELECT id, title, chapo, content, createdAt, updatedAt, idUser FROM blog_post WHERE  id = ?';
        $result = $this->sql($sql, [$idBlogPost]);
        $row = $result->fetch();
        if($row){

            return $this->buildObjectBlogPost($row);
        }
    }

    private function buildObjectBlogPost(array $row)
    {
        $article = new BlogPost();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setChapo($row['chapo']);
        $article->setContent($row['content']);
        $article->setCreatedAt($row['createdAt']);
        $article->setUpdatedAt($row['updatedAt']);
        $article->setIdUser($row['idUser']);

        return $article;
    }
}