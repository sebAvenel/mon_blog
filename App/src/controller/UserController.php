<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;

/**
 * Class UserController
 * @package App\src\controller
 */
class UserController extends Controller
{
    private $userDAO;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->userDAO = new UserDAO();
    }

    /**
     * User Authentication
     *
     * @param string $emailUser
     * @param string $pwdUser
     * @param bool $rememberUser
     */
    public function authUser($emailUser, $pwdUser, $rememberUser)
    {
        if (isset($_SESSION['errorAuthUser'])){
            unset($_SESSION['errorAuthUser']);
        }
        if ($rememberUser){
            setcookie('email', $emailUser, time() + 365*24*3600, null, null, false, true);
            setcookie('password', $pwdUser, time() + 365*24*3600, null, null, false, true);
        }
        $this->userDAO->authUser($emailUser, $pwdUser);
        if (isset($_SESSION['infosUser'])){
            return header('Location: ../public/index.php');
        } elseif (isset($_SESSION['errorAuthUser'])){
            return header('Location: ../public/index.php?route=signIn');
        }
    }

    /**
     * User disconnection
     */
    public function disconnectUser(){
        session_destroy();
        return header('Location: ../public/index.php');
    }
}