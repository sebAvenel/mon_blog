<?php

namespace App\src\model;

/**
 * Class User
 * @package App\src\model
 */
class User
{
    private $id;
    private $name;
    private $password;
    private $email;
    private $role;
    private $keyActivate;
    private $isActivate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getKeyActivate()
    {
        return $this->keyActivate;
    }

    /**
     * @param sting $keyActivate
     */
    public function setKeyActivate($keyActivate)
    {
        $this->keyActivate = $keyActivate;
    }

    /**
     * @return int
     */
    public function getisActivate()
    {
        return $this->isActivate;
    }

    /**
     * @param int $isActivate
     */
    public function setIsActivate($isActivate)
    {
        $this->isActivate = $isActivate;
    }
}
