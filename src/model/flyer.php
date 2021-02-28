<?php
namespace Model;

/**
 * Class Flyer
 */
class Flyer extends Model {
    /**
     * @return array or null
     */
    public function findAll(): ?array
    {
        $sql = "
            SELECT id, name, store_name, date_valid, date_expired, page_count
            FROM flyer
            WHERE date_expired >= CURDATE()";

        try {
            $query = $this->database->query($sql);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return array or null
     */
    public function find(int $id): ?array
    {
        $sql = "SELECT id, name, store_name, date_valid, date_expired, page_count FROM flyer WHERE id = :id";

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
     * @param array $id
     * @return int or null
     */
    public function insert(array $flyer): ?int
    {
        $sql = "
            INSERT INTO flyer (name, store_name, date_valid, date_expired, page_count)
            VALUES (:name, :store_name, :date_valid, :date_expired, :page_count)
        ";
    
        try {
            $query = $this->database->prepare($sql);
            $query->execute([
                'name' => $flyer['name'],
                'store_name'  => $flyer['storeName'],
                'date_valid' => $flyer['dateValid'],
                'date_expired' => $flyer['dateExpired'],
                'page_count' => $flyer['pageCount']
            ]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @param array $flyer
     * @return int or null
     */
    public function update(int $id, array $flyer): ?int
    {
        $sql = "
            UPDATE flyer 
            SET name = :name,
                store_name  = :store_name,
                date_valid = :date_valid,
                date_expired = :date_expired,
                page_count = :page_count
            WHERE id = :id
        ";

        try {
            $query = $this->database->prepare($sql);
            $query->execute([
                'id' => (int) $id,
                'name' => $flyer['name'],
                'store_name'  => $flyer['storeName'],
                'date_valid' => $flyer['dateValid'],
                'date_expired' => $flyer['dateExpired'],
                'page_count' => $flyer['pageCount']
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
        $sql = "DELETE FROM flyer WHERE id = :id";

        try {
            $query = $this->database->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}