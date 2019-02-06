<?php

namespace App\src\DAO;

use src\model\Comment;


class CommentsDAO extends DAO
{
    public function getCommentsFromBlogPost($idBlogPost){

        $sql = 'SELECT id, content, created_at, updated_at, is_valid, id_blog_post, id_user FROM comment WHERE id_blog_post = ?';
        $result = $this->sql($sql, [$idBlogPost]);
        $comments = [];
        foreach ($result as $row){
            $commentId = $row['id'];
            $comments[$commentId] = $this->buildObjectComment($idBlogPost);
        }
        return $comments;
    }

    private function buildObjectComment(array $row){

        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setUpdatedAt($row['updated_at']);
        $comment->setIsValid($row['is_valid']);
        $comment->setIdBlogPost($row['id_blog_post']);
        $comment->setIdUser($row['id_user']);
    }
}