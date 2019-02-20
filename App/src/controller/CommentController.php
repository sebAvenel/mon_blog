<?php

namespace App\src\controller;


use App\src\DAO\CommentsDAO;

class CommentController
{
    private $commentsDAO;

    public function __construct()
    {
        $this->commentsDAO = new CommentsDAO();
    }

    public function updateComment($idComment, $contentComment, $idBlogPost)
    {
        $this->commentsDAO->updateComment($idComment, $contentComment);
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

    public function deleteComment($idComment, $idBlogPost)
    {
        $this->commentsDAO->deleteComment($idComment);
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

    public function addComment($content, $idBlogPost, $idUser)
    {
        $this->commentsDAO->addComment($content, $idBlogPost, $idUser);
        $_SESSION['addCommentSuccess'] = "Votre commentaire a bien été pris en compte. Il sera publié ou supprimé après validation de nôtre modérateur";
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

}