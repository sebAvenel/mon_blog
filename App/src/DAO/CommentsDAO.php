<?php

namespace App\src\DAO;

use App\src\model\Comment;


class CommentsDAO extends DAO
{
    public function getCommentsFromBlogPost($idBlogPost){

        $sql = 'SELECT id, content, createdAt, DATE_FORMAT(updatedAt, "%d/%m/%Y à %H:%i:%s") AS updatedAt, isValid, idBlogPost, idUser
                FROM comment 
                WHERE comment.idBlogPost = ?';
        $result = $this->sql($sql, [$idBlogPost]);
        $comments = [];
        while ($data = $result->fetch()){
            $commentId = $data['id'];
            $comments[$commentId] = $this->buildObjectComment($data);
        }
        return $comments;

    }

    public function getCommentsFromBlogPostWithUser($idBlogPost){
        $sql = 'SELECT comment.id, comment.content, comment.createdAt, DATE_FORMAT(comment.updatedAt, "%d/%m/%Y à %H:%i:%s") AS updatedAt, comment.isValid, comment.idBlogPost, comment.idUser, user.id AS userId, user.name
                FROM comment 
                INNER JOIN user
                  ON comment.idUser = user.id
                WHERE comment.idBlogPost = ?
                AND comment.isValid = 1';
        $result = $this->sql($sql, [$idBlogPost]);
        $tab = [];
        foreach ($result as $key => $value){
            $tab[$key] = $value;
        }
        return $tab;
    }

    private function buildObjectComment(array $row){

        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setContent($row['content']);
        $comment->setCreatedAt($row['createdAt']);
        $comment->setUpdatedAt($row['updatedAt']);
        $comment->setIsValid($row['isValid']);
        $comment->setIdBlogPost($row['idBlogPost']);
        $comment->setIdUser($row['idUser']);
        return $comment;
    }
}