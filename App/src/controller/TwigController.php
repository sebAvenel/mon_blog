<?php

namespace App\src\controller;

class TwigController
{
    protected $getTwig;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem('../templates');
        $this->getTwig = new \Twig_Environment($loader, [
            'cache' => false, // __DIR__ . 'tmp'
        ]);
        $this->getTwig->addGlobal('session', $_SESSION);
    }
}