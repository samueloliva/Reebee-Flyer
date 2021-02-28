<?php
namespace Model;

/**
 * Class Page
 */
class Page {
    private $database;

    /*
     * @param PDO $database
     */
    public function __construct(\PDO $database) {
        $this->database = $database;
    }

    /**
     * @param int $id
     * @return array or null
     */
    public function findAllById(int $id): ?array {
        $sql = "
            SELECT  id, date_valid, date_expired, 
                    page_number, flyer_id
            FROM page
            WHERE flyer_id = :flyer_id
            ORDER BY page_number";

        try {
            $query = $this->database->prepare($sql);
            $query->execute(['flyer_id' => $id]);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array or null
     */
    public function find(int $id): ?array {
        $sql = "SELECT  id, date_valid, date_expired, 
                        page_number, flyer_id 
                FROM page 
                WHERE id = :id";

        try {
            $query = $this->database->prepare($sql);
            $query->execute(['id' => $id]);
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            $result = !is_bool($result) ? $result : [];
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param array $page 
     * @return int or null
     */
    public function insert(array $page): ?int {
        $sql = "INSERT INTO page (date_valid, date_expired, page_number, flyer_id)
                VALUES (:date_valid, :date_expired, :page_number, :flyer_id)";

        try {
            $query = $this->database->prepare($sql);
            $query->execute([
                'date_valid' => $page['dateValid'],
                'date_expired' => $page['dateExpired'],
                'page_number' => $page['pageNumber'],
                'flyer_id' => $page['flyerId']
            ]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $page
     * @return int or null
     */
    public function update(int $id, array $page): ?int
    {
        $sql = "UPDATE page 
                SET date_valid = :date_valid,
                    date_expired = :date_expired,
                    page_number = :page_number,
                    flyer_id = :flyer_id
                WHERE id = :id";

        try {
            $query = $this->database->prepare($sql);
            $query->execute([
                'id' => (int) $id,
                'date_valid' => $page['dateValid'],
                'date_expired' => $page['dateExpired'],
                'page_number' => $page['pageNumber'],
                'flyer_id' => $page['flyerId']
            ]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id 
     * @return int or null
     */
    public function delete(int $id): ?int
    {
        $sql = "DELETE FROM page 
                WHERE id = :id";

        try {
            $query = $this->database->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}