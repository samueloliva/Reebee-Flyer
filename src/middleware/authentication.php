<?php
namespace Middleware;

use Service\User;

/**
 * Class Authentication
 */
class Authentication {
    private $service;
    private $users;
    private $username;
    private $password;

    /**
     * Auth constructor
     * @param PDO
     */
    public function __construct(\PDO $database)
    {
        $this->username = $_SERVER['PHP_AUTH_USER'] ?? null;
        $this->password = $_SERVER['PHP_AUTH_PW'];
        $this->service = new User($database);
        $this->users = $this->service->get();
    }

    /**
     * @return array or null
     */
    public function execute(): ?array {
        if (!$this->check()) {
            $response['status'] = ["code" => 401, "message" => "Unauthorized"];
            $response['body'] = "Access not granted.";
            return $response;
        }
        return null;
    }

    /**
     * @return bool
     */
    private function check(): bool {
        if (!empty($this->username) && !empty($this->password)) 
            if (array_key_exists($this->username, $this->users)) 
                if (password_verify($this->password, $this->users[$this->username])) 
                    return true;

        return false;
    }

}