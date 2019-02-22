<?php

namespace App\src\DAO;

/**
 * Class UserDAO
 * @package App\src\DAO
 */
class UserDAO extends DAO
{

    /**
     * Check for the presence of a user's email in the DB
     *
     * @param string $emailUser
     * @return mixed
     */
    public function checkMailUser($emailUser)
    {
        $sql = 'SELECT email FROM user WHERE email = ?';
        $result = $this->sql($sql, [$emailUser]);
        $response = $result->fetch();

        return $response;
    }

    /**
     * Return a variable $ _SESSION
     *
     * @param string $emailUser
     * @param string $pwdUser
     */
    public function authUser($emailUser, $pwdUser)
    {
        if ($this->checkMailUser($emailUser)){
            $sql = 'SELECT id, name, email, password, role FROM user WHERE email = ?';
            $result = $this->sql($sql, [$emailUser]);
            $response = $result->fetch();
            if($response['password'] === $pwdUser)
            {
                $infoUser = [];
                foreach ($response as $key => $value){
                    $infoUser[$key . 'User'] = $value;
                }
                $_SESSION['infosUser'] = $infoUser;
            }else{
                $_SESSION['errorAuthUser'] = 'Email ou mot de passe incorrect';
            }
        }else{
            $_SESSION['errorAuthUser'] = 'Email ou mot de passe incorrect';
        }
    }
}