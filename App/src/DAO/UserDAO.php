<?php

namespace App\src\DAO;

use App\src\model\User;


class UserDAO extends DAO
{

    public function verifMailUser($emailUser)
    {
        $sql = 'SELECT email FROM user WHERE email = ?';
        $result = $this->sql($sql, [$emailUser]);
        $response = $result->fetch();
        return $response;
    }

    public function authUser($emailUser, $pwdUser)
    {
        if ($this->verifMailUser($emailUser)){
            $sql = 'SELECT id, name, email, password, role FROM user WHERE email = ?';
            $result = $this->sql($sql, [$emailUser]);
            $response = $result->fetch();
            if($response['password'] === $pwdUser)
            {
                $infosUser = [];
                foreach ($response as $key => $value){
                    $infosUser[$key . 'User'] = $value;
                }
                $_SESSION['infosUser'] = $infosUser;
                //var_dump($_SESSION['infosUser']);
                //echo $_SESSION['infosUser']['idUser'];
            }else{
                $_SESSION['errorAuthUser'] = 'Email ou mot de passe incorrect';
            }
        }else{
            $_SESSION['errorAuthUser'] = 'Email ou mot de passe incorrect';
        }
    }
}