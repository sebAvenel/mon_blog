<?php

namespace App\src\controller;

use App\src\service\DataControl;
use App\src\service\Sanitize;
use App\src\DAO\BlogPostDAO;
use App\src\DAO\CommentsDAO;

/**
 * Class BlogPostController
 * @package App\src\controller
 */
class BlogPostController extends Controller
{
    private $blogPostDAO;
    private $commentsDAO;
    private $sessionArray;

    /**
     * BlogPostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogPostDAO = new BlogPostDAO();
        $this->commentsDAO = new CommentsDAO();
        $this->sessionArray = array('addCommentSuccess', 'errorUpdateComment', 'successUpdateComment', 'errorAddComment');
    }

    /**
     * Displays the view that contains the list of blog posts
     */
    public function blogPostsList()
    {
        $pageNumber = Sanitize::onString('get', 'page');
        if (isset($_GET['blogPostPerPage'])) {
            $blogPostPerPage = (int) Sanitize::onString('get', 'blogPostPerPage');
        } elseif (isset($_POST['blogPostPerPage'])) {
            $blogPostPerPage = (int) Sanitize::onString('post', 'blogPostPerPage');
        } else {
            $blogPostPerPage = 3;
        }
        $blogPostCount = $this->blogPostDAO->count();
        $numberOfPage = ceil($blogPostCount/$blogPostPerPage);
        if ($pageNumber > $numberOfPage) {
            $currentPage = $numberOfPage;
        } elseif ($pageNumber < 1) {
            $currentPage = 1;
        } else {
            $currentPage = $pageNumber;
        }
        $firstBlogPost = ($currentPage-1)*$blogPostPerPage;
        echo $this->twig->render('blogPost/blogPostsList.twig', [
            'blogPostsList' => $this->blogPostDAO->getAll($firstBlogPost, $blogPostPerPage),
            'numberOfPage' => $numberOfPage,
            'blogPostPerPage' => $blogPostPerPage
        ]);

        return;
    }

    /**
     * Displays the view that contains a blog post with comments
     *
     * @param int $idBlogPost
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function blogPostWithComments(int $idBlogPost)
    {
        $this->sessionCleaner($this->sessionArray);
        echo $this->twig->render('blogPost/blogPostWithComments.twig', [
            'blogPost' => $this->blogPostDAO->getOneById($idBlogPost),
            'comments' => $this->commentsDAO->getCommentsFromBlogPost($idBlogPost)
        ]);

        return;
    }

    /**
     * Update a blog post
     *
     * @param int $id
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function updateBlogPost(int $id)
    {
        $title = Sanitize::onString('post', 'inputAdminBlogPostTitle');
        $chapo = Sanitize::onString('post', 'inputAdminBlogPostChapo');
        $content = Sanitize::onString('post', 'inputAdminBlogPostContent');
        $errors = [];

        if (DataControl::stringControl($title, 'titre', 10, 75)) {
            $errors['title'] = DataControl::stringControl($title, 'titre', 10, 75);
        }

        if (DataControl::stringControl($chapo, 'châpo', 10, 200)) {
            $errors['chapo'] = DataControl::stringControl($chapo, 'châpo', 10, 200);
        }

        if (DataControl::stringControl($content, 'contenu', 100, 5000)) {
            $errors['content'] = DataControl::stringControl($content, 'contenu', 100, 5000);
        }

        if (!empty($errors)) {
            echo $this->twig->render('admin/blogPostsAdmin.twig', [
                'errors' => $errors,
                'blogPostsList' => $this->blogPostDAO->getAll(0, $this->blogPostDAO->count()),
                'inputsContent' => $_POST
            ]);

            return;
        }

        $this->blogPostDAO->updateBlogPost($title, $chapo, $content, $id);

        return header('Location: ../public/index.php?route=adminBlogPosts');
    }

    /**
     * Add a blog post
     *
     * @return void
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function addBlogPost()
    {
        $title = Sanitize::onString('post', 'inputAdminBlogPostTitle');
        $chapo = Sanitize::onString('post', 'inputAdminBlogPostChapo');
        $content = Sanitize::onString('post', 'inputAdminBlogPostContent');
        $errors = [];

        if (DataControl::stringControl($title, 'titre', 10, 75)) {
            $errors['title'] = DataControl::stringControl($title, 'titre', 10, 75);
        }

        if (DataControl::stringControl($chapo, 'châpo', 10, 200)) {
            $errors['chapo'] = DataControl::stringControl($chapo, 'châpo', 10, 200);
        }

        if (DataControl::stringControl($content, 'contenu', 100, 5000)) {
            $errors['content'] = DataControl::stringControl($content, 'contenu', 100, 5000);
        }

        if (!empty($errors)) {
            echo $this->twig->render('admin/blogPostsAdmin.twig', [
                'errors' => $errors,
                'blogPostsList' => $this->blogPostDAO->getAll(0, $this->blogPostDAO->count())
            ]);

            return;
        }

        $this->blogPostDAO->addBlogPost($title, $chapo, $content);

        return header('Location: ../public/index.php?route=adminBlogPosts');
    }

    /**
     * Delete a blog post
     *
     * @param $idBlogPost
     */
    public function deleteBlogPost(int $idBlogPost)
    {
        $this->blogPostDAO->deleteById($idBlogPost);

        return header('Location: ../public/index.php?route=adminBlogPosts');
    }
}
