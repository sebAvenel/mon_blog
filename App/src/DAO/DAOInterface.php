<?php

namespace App\src\DAO;

/**
 * Interface DAOInterface
 * @package App\src\DAO
 */
interface DAOInterface
{
    public function getAll(int $first, int $last);

    public function getOneById(int $id);

    public function deleteById(int $id);
}
