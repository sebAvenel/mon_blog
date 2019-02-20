<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;

class UserController extends TwigController
{
    private $userDAO;

    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
    }

    public function authUser($emailUser, $pwdUser, $rememberUser)
    {
        if ($rememberUser){
            setcookie('email', $emailUser, time() + 365*24*3600, null, null, false, true);
            setcookie('password', $pwdUser, time() + 365*24*3600, null, null, false, true);
        }
        $this->userDAO->authUser($emailUser, $pwdUser);
        if (isset($_SESSION['infosUser'])){
            header('Location: ../public/index.php');
        }elseif (isset($_SESSION['errorAuthUser'])){
            header('Location: ../public/index.php?route=signin');
        }
    }

    public function disconnectUser(){
        session_destroy();
        header('Location: ../public/index.php');
    }
}