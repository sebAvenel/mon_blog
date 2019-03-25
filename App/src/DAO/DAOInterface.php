<?php

namespace App\src\DAO;

/**
 * Interface DAOInterface
 * @package App\src\DAO
 */
interface DAOInterface
{
    public function getAll();

    public function getOneById(array $array);

    public function deleteById($id);
}
