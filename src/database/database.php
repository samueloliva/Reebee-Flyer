<?php
namespace Database;

/**
 * Class Database
 */
class Database {
    private $connection = null;

    /**
     * Database constructor
     */
    public function __construct() {
        $alias = getenv('MYSQL_ALIAS');
        $database   = getenv('MYSQL_DATABASE');
        $user = getenv('MYSQL_USER');
        $password = getenv('MYSQL_PASSWORD');

        try {
            $this->connection = new \PDO(
                sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", $alias, $database),
                $user,
                $password,
                [
                    \PDO::ATTR_STRINGIFY_FETCHES => false,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        }
        catch (\PDOException $e) {
            die("Caught PDO exception: " . $e->getMessage());
        }
    }

    /**
     * @return PDO $connection
     */
    public function getConnection() {
        return $this->connection;
    }
}