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
     * Generate a random string
     *
     * @param int $length
     * @return string
     */
    public function randomString($length = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$@&';
        $lengthChars = strlen($chars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++){
            $randomString .= $chars[rand(0, $lengthChars - 1)];
        }
        return $randomString;
    }

    public function errorViewDisplay($message)
    {
        echo $this->Twig->render('error/error.twig', [
            'errorMessage' => $message
        ]);
    }
}
