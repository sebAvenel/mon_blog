<?php

namespace App\src\controller;

/**
 * Class Controller
 * @package App\src\controller
 */
class Controller
{
    protected $Twig;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem('../templates');
        $this->Twig = new \Twig_Environment($loader, [
            'cache' => false, // __DIR__ . 'tmp'
        ]);
        $this->Twig->addGlobal('session', $_SESSION);
        $this->Twig->addGlobal('cookie', $_COOKIE);
        $this->Twig->addGlobal('get', $_GET);
    }

    /**
     * Clean unnecessary session items
     *
     * @param array $sessionArray
     */
    public function sessionCleaner(array $sessionArray)
    {
        foreach ($sessionArray as $item) {
            if (isset($_SESSION[$item])) {
                unset($_SESSION[$item]);
            }
        }
    }

    /**
     * Display the error page
     *
     * @param $message
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function errorViewDisplay($message)
    {
        echo $this->Twig->render('error/error.twig', [
            'errorMessage' => $message
        ]);
    }
}
