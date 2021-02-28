<?php
namespace Service;

use Model\Flyer as FlyerModel;

/**
 * Class Flyer
 */
class Flyer extends Service {
    /**
     * @param PDO $database
     */
    public function __construct(\PDO $database)
    {
        $model = new FlyerModel($database);
        parent::__construct($database, $model, 'flyer');
    }
}