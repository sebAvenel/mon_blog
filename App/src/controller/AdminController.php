<?php

namespace App\src\controller;

/**
 * Class AdminController
 * @package App\src\controller
 */
class AdminController extends Controller
{
    /**
     * AdminController constructor.
     */
    public function  __construct()
    {
        parent::__construct();
    }

    /**
     * Display the blog posts administration page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function blogPostsAdminPage()
    {
        echo $this->Twig->render('admin/blogPostsAdmin.twig');
    }

    /**
     * Display the comments administration page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function commentsAdminPage()
    {
        echo $this->Twig->render('admin/commentsAdmin.twig');
    }

    /**
     * Display the profiles administration page
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function profilesAdminPage()
    {
        echo $this->Twig->render('admin/profilesAdmin.twig');
    }

}
