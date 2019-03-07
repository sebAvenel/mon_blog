<?php

namespace App\src\DAO;

/**
 * Class CommentsDAO
 * @package App\src\DAO
 */
class CommentsDAO extends DAO
{
    /**
     * Return a list of comments from blog post
     *
     * @param int $idBlogPost
     * @return array
     */
    public function getCommentsFromBlogPost($idBlogPost)
    {
        $sql = 'SELECT comment.id, comment.content, comment.createdAt, DATE_FORMAT(comment.updatedAt, "%d/%m/%Y à %H:%i:%s") AS updatedAt, comment.isValid, comment.idBlogPost, comment.idUser, users.id AS userId, users.name
                FROM comment 
                INNER JOIN users
                  ON comment.idUser = users.id
                WHERE comment.idBlogPost = ?
                AND comment.isValid = 1';
        $result = $this->sql($sql, [$idBlogPost]);
        $tab = [];
        foreach ($result as $key => $value){
            $tab[$key] = $value;
        }

        return $tab;
    }

    /**
     * Update a comment
     *
     * @param int $idComment
     * @param string $contentComment
     */
    public function updateComment($idComment, $contentComment)
    {
        $sql = 'UPDATE comment SET content = :newContent, updatedAt = NOW(), isValid = 0 where id = :idComment';
        $arrayUpdateComment = [
            'newContent' => $contentComment,
            'idComment' => $idComment
        ];
        $this->sql($sql, $arrayUpdateComment);
    }

    /**
     * Delete a comment
     *
     * @param int $idComment
     */
    public function deleteComment($idComment)
    {
        $sql = 'DELETE FROM comment WHERE id = ' . $idComment;
        $this->sql($sql);
    }

    /**
     * Add a comment to a blog post
     *
     * @param string $content
     * @param int $idBlogPost
     * @param int $idUser
     */
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
