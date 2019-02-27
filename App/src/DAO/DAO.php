<?php

namespace App\src\DAO;

use PDO;

/**
 * Class DAO
 * @package App\src\DAO
 */
abstract class DAO
{

    private $connection;


    /**
     * Return the PDO connection
     *
     * @return PDO
     */
    private function checkConnection()
    {
        if ($this->connection === null) {
            return $this->getConnection();
        }

        return $this->connection;
    }


    /**
     * Check the connection to the DB
     *
     * @return PDO
     */
    public function getConnection()
    {
        try {
            $this->connection = new PDO(DB_HOST, DB_USER, DB_PASS);
            $this->connection->exec('SET NAMES utf8');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->connection;
        }

        catch(\Exception $errorConnection) {
            die ('Erreur de connection :'.$errorConnection->getMessage());
        }
    }

    /**
     * Returns the result of a sql query
     *
     * @param string $sql
     * @param null $parameters
     * @return bool|\PDOStatement
     */
    protected function sql($sql, $parameters = null)
    {
        if ($parameters) {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);

            return $result;
        } else {
            $result = $this->checkConnection()->query($sql);

            return $result;
        }
    }
}
