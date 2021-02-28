<?php

namespace Service;

use Model\User as UserModel;

/**
 * Class User
 */
class User {
    private $model;

    /**
     * @param PDO $database
     */
    public function __construct(\PDO $database) {
        $this->model = new UserModel($database);
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $users = $this->model->findAll();
        $response = [];
        foreach ($users as $user) {
            $response[$user['username']] = $user['password'];
        }
        return $response;
    }

    /**
     * @param array $user
     * @return array
     */
    public function create(array $user): array
    {
        $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
        $this->model->insert($user);
        $response['status'] = ["code" => 201, "message" => "Created"];
        $response['body'] = null;

        return $response;
    }

}