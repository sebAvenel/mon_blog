<?php

namespace App\src\controller;

use App\src\DAO\CommentsDAO;

/**
 * Class CommentController
 * @package App\src\controller
 */
class CommentController
{
    private $commentsDAO;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        $this->commentsDAO = new CommentsDAO();
    }

    /**
     * Update a comment and redirect to the modified comment page
     *
     * @param int $idComment
     * @param string $contentComment
     * @param int $idBlogPost
     */
    public function updateComment($idComment, $contentComment, $idBlogPost)
    {
        if (strlen($contentComment) > 500 || strlen($contentComment) < 3) {
            $errors = [];
            $errors['idComment'] = $idComment;
            $errors['content'] = 'Modification refusée, votre commentaire doit comporter entre 3 et 500 caractères';
            $_SESSION['errorUpdateComment'] = $errors;
        } else {
            $_SESSION['successUpdateComment'] = 'La modification de votre commentaire est en attente de validation du modérateur, merci de votre compréhension';
            $this->commentsDAO->updateComment($idComment, $contentComment);
        }
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

    /**
     * Delete comment by a user
     *
     * @param int $idComment
     * @param int $idBlogPost
     */
    public function deleteComment($idComment, $idBlogPost)
    {
        $this->commentsDAO->deleteComment($idComment);
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

    /**
     * Delete comment by admin
     *
     * @param $idComment
     * @param $idBlogPost
     */
    public function deleteCommentByAdmin($idComment, $idBlogPost)
    {
        $this->commentsDAO->deleteComment($idComment);
        header('Location: ../public/index.php?route=adminComments&idBlogPostCommentsAdmin=' . $idBlogPost . '#listOfInvalidComments');
    }

    /**
     * Add a comment and redirects to the added comment page
     *
     * @param string $content
     * @param int $idBlogPost
     * @param int $idUser
     */
    public function addComment($content, $idBlogPost, $idUser)
    {
        if (strlen($content) > 500 || strlen($content) < 3) {
            $_SESSION['errorAddComment'] = 'Votre commentaire doit comporter entre 3 et 500 caractères';
        } else {
            $this->commentsDAO->addComment($content, $idBlogPost, $idUser);
            $_SESSION['addCommentSuccess'] = "Votre commentaire a bien été pris en compte. Il sera publié ou supprimé après validation du modérateur";
        }
        header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
    }

    /**
     * Valid comment by admin
     *
     * @param $idComment
     * @param $idBlogPost
     */
    public function validComment($idComment, $idBlogPost)
    {
        $this->commentsDAO->validComment($idComment);
        header('Location: ../public/index.php?route=adminComments&idBlogPostCommentsAdmin=' . $idBlogPost . '#listOfInvalidComments');
    }
}
