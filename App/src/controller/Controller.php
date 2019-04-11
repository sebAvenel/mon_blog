<?php

namespace App\src\controller;

/**
 * Class Controller
 * @package App\src\controller
 */
class Controller
{
    /** @var \Twig\Environment */
    protected $twig;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../templates');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false, // __DIR__ . 'tmp'
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('cookie', $_COOKIE);
        $this->twig->addGlobal('get', $_GET);
        $this->twig->addExtension(new \Twig_Extensions_Extension_Text());
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
     *
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     *
     * @return string
     */
    public function errorViewDisplay(string $message): string
    {
        return $this->twig->render('error/error.twig', [
            'errorMessage' => $message
        ]);
    }
}
