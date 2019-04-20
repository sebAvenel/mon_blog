<?php

namespace App\src\controller;

use App\src\service\DataControl;
use App\src\service\Sanitize;
use App\src\DAO\CommentsDAO;

/**
 * Class CommentController
 * @package App\src\controller
 */
class CommentController extends Controller
{
    private $commentsDAO;

    /**
     * CommentController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->commentsDAO = new CommentsDAO();
    }

    /**
     * Update a comment and redirect to the modified comment page
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateComment()
    {
        if ($_GET['token'] == $_SESSION['token']){
            $idComment = Sanitize::onInteger('get', 'idComment');
            $idBlogPost = Sanitize::onInteger('get', 'idBlogPost');
            $contentComment = Sanitize::onString('post', 'textareaModifComment');
            if (DataControl::stringControl($contentComment, 'Commentaire', 3, 500)) {
                $errors = [];
                $errors['idComment'] = $idComment;
                $errors['content'] = DataControl::stringControl($contentComment, 'Commentaire', 3, 500);
                $_SESSION['errorUpdateComment'] = $errors;

                return header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost . '#commentId' . $idComment);
            }

            $_SESSION['successUpdateComment'] = 'La modification de votre commentaire est en attente de validation du modérateur, merci de votre compréhension';
            $this->commentsDAO->updateComment($idComment, $contentComment);

            return header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
        }

        echo $this->errorViewDisplay('Une erreur est survenue');
    }

    /**
     * Delete comment by a user
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteCommentByUser()
    {
        if ($_GET['token'] == $_SESSION['token']){
            $idComment = Sanitize::onInteger('get', 'idComment');
            $idBlogPost = Sanitize::onInteger('get', 'idBlogPost');
            $this->commentsDAO->deleteById($idComment);

            return header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
        }

        echo $this->errorViewDisplay('Une erreur est survenue');
    }

    /**
     * Delete comment by admin
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function deleteCommentByAdmin()
    {
        if ($_GET['token'] == $_SESSION['token']){
            $idComment = Sanitize::onInteger('get' , 'idDeleteComment');
            $idBlogPost = Sanitize::onInteger('get', 'idBlogPost');
            $this->commentsDAO->deleteById($idComment);

            return header('Location: ../public/index.php?route=adminCommentsCheck&idBlogPostCommentsAdmin=' . $idBlogPost . '#listOfInvalidComments');
        }

        echo $this->errorViewDisplay('Une erreur est survenue');
    }

    /**
     * Add a comment and redirects to the added comment page
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addComment()
    {
        if ($_GET['token'] == $_SESSION['token']){
            $idBlogPost = Sanitize::onInteger('get', 'idBlogPost');
            $idUser = Sanitize::onInteger('get', 'idUser');
            $content = Sanitize::onString('post', 'textareaAddComment');
            if (DataControl::stringControl($content, 'commentaire', 3, 500)) {
                $_SESSION['errorAddComment'] = DataControl::stringControl($content, 'commentaire', 3, 500);
                return header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost . '#addCommentCard');
            }

            $this->commentsDAO->addComment($content, $idBlogPost, $idUser);
            $_SESSION['addCommentSuccess'] = "Votre commentaire a bien été pris en compte. Il sera publié ou supprimé après validation du modérateur";

            return header('Location: ../public/index.php?route=blogPostWithComments&idBlogPost=' . $idBlogPost);
        }

        echo $this->errorViewDisplay('Une erreur est survenue');
    }

    /**
     * Valid comment by admin
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function validComment()
    {
        if ($_GET['token'] == $_SESSION['token']){
            $idComment = Sanitize::onInteger('get', 'idValidComment');
            $idBlogPost = Sanitize::onInteger('get', 'idBlogPost');
            $this->commentsDAO->validComment($idComment);

            return header('Location: ../public/index.php?route=adminCommentsCheck&idBlogPostCommentsAdmin=' . $idBlogPost . '#listOfInvalidComments');
        }

        echo $this->errorViewDisplay('Une erreur est survenue');
    }
}
