<?php

namespace App\src\DAO;

class CommentsDAO extends DAO
{

    public function getCommentsFromBlogPost($idBlogPost)
    {
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

    public function updateComment($idComment, $contentComment)
    {
        $sql = 'UPDATE comment SET content = :newContent, updatedAt = NOW() where id = :idComment';
        $arrayUpdateComment = [
            'newContent' => $contentComment,
            'idComment' => $idComment
        ];
        $this->sql($sql, $arrayUpdateComment);
    }

    public function deleteComment($idComment)
    {
        $sql = 'DELETE FROM comment WHERE id = ' . $idComment;
        $this->sql($sql);
    }

    public function addComment($content, $idBlogPost, $idUser)
    {
        $sql = 'INSERT INTO comment(content, createdAt, updatedAt, isValid, idBlogPost, idUser)
                VALUES(:content, NOW(), NOW(), :isValid, :idBlogPost, :idUser)';
        $arrayAddComment = [
            'content' => $content,
            'isValid' => 0,
            'idBlogPost' => $idBlogPost,
            'idUser' => $idUser
        ];
        $this->sql($sql, $arrayAddComment);
    }

}