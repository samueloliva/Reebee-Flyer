<?php
namespace Controller;

use Middleware\Authentication;

/**
 * Class controller
 */
class Controller {
    protected $service;
    protected $requestMethod;
    protected $parameter;

    /**
     * Controller contructor
     * @param Service $service
     * @param string $requestMethod
     * @param string $parameter
     */
    public function __construct($service, string $requestMethod, string $parameter=null)
    {
        $this->service = $service;
        $this->requestMethod = $requestMethod;
        $this->parameter = $parameter;
    }

    /**
     * @return array This returns the request response
     */
    public function request(): array {
        if ($this->requestMethod != 'GET') {
            $authentication = new Authentication($this->service->database);
            if ($authentication->execute())
                return $authentication->execute();
        }

        if ($this->requestMethod == 'GET') {
            $response = $this->get();
        }
        else if ($this->requestMethod == 'PUT') {
            $response = $this->put();
        }
        else if ($this->requestMethod == 'POST') {
            $response = $this->post();
        }
        else if ($this->requestMethod == 'DELETE') {
            $response = $this->delete();
        }
        else {
            $response = $this->failResponse(404);
        }
        return $response;
    }

    /**
     * @return array 
     */
    protected function get(): array
    {
        if ($this->parameter) {
            $response = $this->service->get($this->parameter);
        } else {            
            $response = $this->service->getAll();
        }
        return $response;
    }

    /**
     * @return array 
     */
    protected function post(): array
    {
        $inputData = file_get_contents('php://input');
        $data = (array) json_decode(trim($inputData), TRUE);
        if (!$this->validate($data)) 
            return $this->failResponse();
        $response = $this->service->create($data);
        return $response;
    }

    /**
     * @return array 
     */
    protected function put(): array
    {
        $inputData = file_get_contents('php://input');
        $data = (array) json_decode(trim($inputData), TRUE);
        if (!$this->validate($data))
            return $this->failResponse();
        $response = $this->service->update($this->parameter, $data);

        return $response;
    }

    /**
     * @return array 
     */
    protected function delete(): array
    {
        $response = $this->service->delete($this->parameter);
        return $response;
    }

    /**
     * @return array 
     */
    protected function failResponse($status): array {
        if ($status == 404) 
            $response['status'] = ["code" => 404, "message" => "Not Found"];
        if ($status == 422) 
            $response['status'] = ["code" => 422, "message" => "Unprocessable Entity"];
        $response['body'] = null;
        return $response;
    }

}