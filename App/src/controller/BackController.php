<?php

namespace App\src\controller;

use App\src\DAO\UserDAO;


class BackController
{
    private $userDAO;

    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    public function verifMailUser($emailUser)
    {
        $verifMail = $this->userDAO->verifMailUser($emailUser);
        return $verifMail;
    }

    public function authUser($emailUser, $pwdUser)
    {
        $authUser = $this->userDAO->authUser($emailUser, $pwdUser);
        return $authUser;
    }

}