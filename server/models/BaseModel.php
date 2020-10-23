<?php

namespace server\controllers;

use server\core\Database;

class BaseModel
{
    protected $tableName = null;

    protected $conn;

    public function __construct()
    {
        $db = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    public function getId()
    {
        $selectQuery = <<<SQL
        SELECT id from {$this->tableName}
        WHERE name = :name
        SQL;

        $stms = $this->conn->prepare($selectQuery);
        $stms->bindValue(':name', $this->name, PDO::PARAM_STR);
        $result = $stms->execute(); // todo: change this fetch is needed as well

        return $result;
    }
}