<?php
namespace Service;

/**
 * Class Service
 */
class Service {
    protected $model;
    protected $name;
    public $database;

    /**
     * @param PDO $database
     * @param Model $model
     * @param string $name
     */
    public function __construct(\PDO $database, $model, string $name) {
        $this->database = $database;
        $this->model = $model;
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getAll(): array {
        $result = $this->model->findAll();
        
        foreach ($result as $key => $value)
            $result[$key] = $value;

        $response['status'] = $this->successResponse(200);
        $response['body'] = json_encode($result);

        return $response;
    }

    /**
     * @param string $id
     * @return array
     */
    public function get($id): array {
        $result = $this->model->find((int) $id);
        if (!$result)
            return $this->failResponse();

        $response['status'] = $this->successResponse(200);
        $response['body'] = json_encode($result);

        return $response;
    }

    /**
     * @param array $item
     * @return array 
     */
    public function create(array $item): array {
        $this->model->insert($item);
        $response['status'] = $this->successResponse(201);
        $response['body'] = null;
        return $response;
    }

    /**
     * @param string $id
     * @param array $item
     * @return array
     */
    public function update($id, array $item): array {
        $result = $this->model->find((int) $id);
        if (!$result)
            return $this->failResponse();

        $this->model->update($id, $item);
        $response['status'] = $this->successResponse(200);
        $response['body'] = null;

        return $response;
    }

    /**
     * @param string $id
     * @return array
     */
    public function delete($id): array {
        if (!$this->model->find((int) $id)) 
            return $this->failResponse();

        $this->model->delete((int) $id);
        $response['status'] = $this->successResponse(200);
        $response['body'] = null;

        return $response;
    }

    /**
     * @return array
     */
    private function failResponse(): array {
        $response['status'] = ["code" => 404, "message" => "Not Found"];
        $response['body'] = null;
        return $response;
    }

    /**
     * @param int $status
     * @return array
     */
    private function successResponse($status): array {
        if ($status == 200) 
            return ["code" => $status, "message" => "OK"];
        if ($status == 201)
            return ["code" => $status, "message" => "Created"];
    }

}