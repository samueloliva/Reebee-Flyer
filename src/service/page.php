<?php
namespace Service;

use Model\Page as PageModel;

/**
 * Class Page
 */
class Page extends Service {
    /**
     * @param PDO $database
     */
    public function __construct(\PDO $database)
    {
        $model = new PageModel($database);
        parent::__construct($database, $model, 'page');
    }

    /**
     * @param string $id
     * @return array
     */
    public function getAllById($id): array
    {
        $result = $this->model->findAllById((int) $id);

        foreach ($result as $key => $value) {
            $result[$key] = $value;
        }
        $response['status'] = ["code" => 200, "message" => "OK"];
        $response['body'] = json_encode($result);

        return $response;
    }
}