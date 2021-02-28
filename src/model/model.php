<?php
namespace Model;

/**
 * Class Model
 */
class Model {
    protected $database;

    /**
     * Model constructor
     * @param PDO $database
     */
    public function __construct(\PDO $database) {
        $this->database = $database;
    }
}