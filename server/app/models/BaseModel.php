<?php

namespace app\models;

use PDO;
use PDOException;
use core\Database;

class BaseModel
{
    /** @var null */
    protected $tableName = null;

    /** @var PDO */
    protected $conn;

    public function __construct()
    {
        $db         = Database::getInstance();
        $this->conn = $db->getConnection();
    }

    /**
     * Get Id from different tables
     *
     * @return bool
     */
    public function getId()
    {
        if (is_null($this->tableName)) {
            die ('table name should not be null');
        }

        try {
            $selectQuery = <<<SQL
            SELECT id from {$this->tableName}
            WHERE name = :name
            SQL;

            $stmt = $this->conn->prepare($selectQuery);
            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $result = $stmt->execute(); // todo: change this fetch is needed as well
            // get category id for teams

            return $result;
        } catch (PDOException $e) {
            echo 'Unable to get the Id form ' . $this->tableName . $e->getMessage();
        }
    }
}