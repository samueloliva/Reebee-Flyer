<?php
namespace Model;

/**
 * Class Users
 */
class User {
    private $database;

    /**
     * @param PDO $database
     */
    public function __construct(\PDO $database) {
        $this->database = $database;
    }

    /**
     * @return array or null
     */
    public function findAll(): ?array {
        $sql = "SELECT username, password FROM user";
        try {
            $query = $this->database->query($sql);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param array $user
     * @return int or null
     */
    public function insert(array $user): ?int {
        $sql = "INSERT INTO user (name, username, password) 
                VALUES (:name, :username, :password)";

        try {
            $query = $this->database->prepare($sql);
            $query->execute([
                'name' => isset($user['name']) ? $user['name'] : null,
                'username'  => $user['username'],
                'password' => $user['password']
            ]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }
}