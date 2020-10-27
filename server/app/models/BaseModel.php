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
}