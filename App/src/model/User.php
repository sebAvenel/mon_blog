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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getKeyActivate()
    {
        return $this->keyActivate;
    }

    /**
     * @param mixed $keyActivate
     */
    public function setKeyActivate($keyActivate)
    {
        $this->keyActivate = $keyActivate;
    }

    /**
     * @return mixed
     */
    public function getisActivate()
    {
        return $this->isActivate;
    }

    /**
     * @param mixed $isActivate
     */
    public function setIsActivate($isActivate)
    {
        $this->isActivate = $isActivate;
    }


}
