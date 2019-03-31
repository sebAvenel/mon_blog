<?php

namespace App\src\DAO;

use App\src\model\User;

/**
 * Class UserDAO
 * @package App\src\DAO
 */
class UserDAO extends DAO implements DAOInterface
{
    public function getAll($first, $last)
    {
        // TODO: Implement getAll() method.
    }

    public function getOneById($id)
    {
        // TODO: Implement getOneById() method.
    }

    /**
     * Return a user object
     *
     * @param $activationKey
     * @return User|null
     */
    public function getUserByKeyActivate($activationKey)
    {
        $sql = 'SELECT id, name, password, email, role, keyActivate, isActivate FROM users WHERE keyActivate = ?';
        $result = $this->sql($sql, [$activationKey]);
        $row = $result->fetch();
        if ($row) {
            return $this->buildObjectUser($row);
        } else {
            return null;
        }
    }

    /**
     * Return a user object
     *
     * @param $userEmail
     * @return User|null
     */
    public function getUserByEmail($userEmail)
    {
        $sql = 'SELECT id, name, password, email, role, keyActivate, isActivate FROM users WHERE email = ?';
        $result = $this->sql($sql, [$userEmail]);
        $row = $result->fetch();
        if ($row) {
            return $this->buildObjectUser($row);
        } else {
            return null;
        }
    }

    /**
     * Return a user list
     *
     * @return array|null
     */
    public function getUsers()
    {
        $sql = 'SELECT id, name, password, email, role, keyActivate, isActivate FROM users';
        $result = $this->sql($sql);
        if ($result) {
            $users = [];
            foreach ($result as $row) {
                $userId = $row['id'];
                $users[$userId] = $this->buildObjectUser($row);
            }
            return $users;
        } else {
            return null;
        }
    }

    /**
     * Delete a user
     *
     * @param $id
     * @return bool|\PDOStatement
     */
    public function deleteById($id)
    {
        $sql = 'DELETE FROM users WHERE id = ' . $id;
        return $this->sql($sql);
    }

    /**
     * Check for the presence of a user's email in the DB
     *
     * @param string $emailUser
     * @return mixed
     */
    public function checkMailUser($emailUser)
    {
        $sql = 'SELECT email FROM users WHERE email = ?';
        $result = $this->sql($sql, [$emailUser]);
        $response = $result->fetch();

        return $response;
    }

    /**
     * User Authentication
     *
     * @param $emailUser
     * @param $pwdUser
     * @return array|null
     */
    public function authUser($emailUser, $pwdUser)
    {
        $sql = 'SELECT id, name, email, password, role, keyActivate, isActivate FROM users WHERE email = ?';
        $result = $this->sql($sql, [$emailUser]);
        $response = $result->fetch();
        if (password_verify($pwdUser, $response['password'])) {
            $infoUser = [];
            foreach ($response as $key => $value) {
                $infoUser[$key . 'User'] = $value;
            }
            return $infoUser;
        } else {
            return null;
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
        $sql = 'UPDATE users SET password = :password where email = :email';
        $arrayUpdatePassword = [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'email' => $emailUser
        ];
        $this->sql($sql, $arrayUpdatePassword);
    }

    /**
     * Update the activation key of a user account
     *
     * @param $emailUser
     */
    public function updateKeyActivateUser($emailUser)
    {
        $sql = 'UPDATE users SET keyActivate = :keyActivate where email = :email';
        $arrayUpdatePassword = [
            'keyActivate' => md5(uniqid("blogSebAvenel")),
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
        $sql = 'INSERT INTO users(name, email, password, role, keyActivate, isActivate)
                VALUES(:name, :email, :password, :role, :keyActivate, :isActivate)';
        $arrayAddComment = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => 'user',
            'keyActivate' => md5(uniqid("blogSebAvenel")),
            'isActivate' => 0
        ];
        $this->sql($sql, $arrayAddComment);
    }

    /**
     * Retrieve the activation key of a user account
     *
     * @param $emailUser
     * @return mixed
     */
    public function getActivateKeyUser($emailUser)
    {
        $sql = 'SELECT keyActivate FROM users WHERE email = ?';
        $result = $this->sql($sql, [$emailUser]);
        $response = $result->fetch();

        return $response["keyActivate"];
    }

    /**
     * Update the activation status of a user
     *
     * @param $activationKey
     */
    public function updateUserActivation($activationKey)
    {
        $sql = 'UPDATE users SET keyActivate = :keyActivate, isActivate = :isActivate where keyActivate = :activationKey';
        $arrayUpdatePassword = [
            'keyActivate' => md5(uniqid("blogSebAvenel")),
            'isActivate' => 1,
            'activationKey' => $activationKey
        ];
        $this->sql($sql, $arrayUpdatePassword);
    }

    /**
     * Update the user role
     *
     * @param $roleUser
     * @param $idUser
     */
    public function updateRoleUser($roleUser, $idUser)
    {
        if ($roleUser == 'admin') {
            $newRoleUser = 'user';
        } else {
            $newRoleUser = 'admin';
        }
        $sql = 'UPDATE users SET role = :role where id = :id';
        $arrayUpdateRoleUser = [
            'role' => $newRoleUser,
            'id' => $idUser
        ];
        $this->sql($sql, $arrayUpdateRoleUser);
    }

    /**
     * Build a user object
     *
     * @param array $row
     * @return User
     */
    private function buildObjectUser(array $row)
    {
        $User = new User();
        $User->setId($row['id']);
        $User->setName($row['name']);
        $User->setPassword($row['password']);
        $User->setEmail($row['email']);
        $User->setRole($row['role']);
        $User->setKeyActivate($row['keyActivate']);
        $User->setIsActivate($row['isActivate']);

        return $User;
    }
}
