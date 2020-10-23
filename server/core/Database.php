<?php
namespace server\core;

use PDO;

require '../config/config.php';

class Database
{
    /** @var null  */
    private static $instance = null;

    /** @var string */
    private $dbHost;

    /** @var string */
    private $dbName;

    /** @var string */
    private $dbUser;

    /** @var string */
    private $dbPass;

    /** @var PDO  */
    private $conn;


    private function __construct(string $host, string $name, string $user, string $pass)
    {
        $this->dbHost = $host;
        $this->dbName = $name;
        $this->dbUser = $user;
        $this->dbPass = $pass;

        $this->conn =
            new PDO(
                "mysql:host={$this->dbHost};dbname={$this->dbName}",
                $this->dbUser,
                $this->dbPass,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
            );
    }

    /**
     * @return Database|null
     */
    public static function getInstance()
    {
        if(!self::$instance)
        {
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