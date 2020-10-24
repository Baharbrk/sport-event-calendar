<?php

namespace core;

use PDO;
use PDOException;

require '../config/config.php';

class Database
{
    /** @var null */
    private static $instance = null;

    /** @var string */
    private $dbHost;

    /** @var string */
    private $dbName;

    /** @var string */
    private $dbUser;

    /** @var string */
    private $dbPass;

    /** @var PDO */
    private $conn;
    

    /**
     * Database constructor.
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $pass
     */
    private function __construct(string $host, string $name, string $user, string $pass)
    {
        $this->dbHost = $host;
        $this->dbName = $name;
        $this->dbUser = $user;
        $this->dbPass = $pass;

        try {
            $this->conn =
                new PDO(
                    'mysql:host=' . $this->dbHost . ';' . 'dbname=' . $this->dbName,
                    $this->dbUser,
                    $this->dbPass,
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'",
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    )
                );
        } catch (PDOException $e) {
            print 'Error!: ' . $e->getMessage() . '<br/>';
            die();
        }
    }

    /**
     * @return Database|null
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASSWORD);
        }

        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->conn;
    }
}