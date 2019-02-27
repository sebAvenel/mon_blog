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
            if (password_verify($pwdUser, $response['password']))
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

    /**
     * Update a user's password
     *
     * @param string $newPassword
     * @param string $emailUser
     */
    public function updatePasswordUser($newPassword, $emailUser)
    {
        $sql = 'UPDATE user SET password = :password where email = :email';
        $arrayUpdatePassword = [
            'password' => $newPassword,
            'email' => $emailUser
        ];
        $this->sql($sql, $arrayUpdatePassword);
    }

    /**
     * Register a user in DB
     *
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function registerUser($name, $email, $password)
    {
        $sql = 'INSERT INTO user(name, email, password, role)
                VALUES(:name, :email, :password, :role)';
        $arrayAddComment = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'user'
        ];
        $this->sql($sql, $arrayAddComment);
    }
}
