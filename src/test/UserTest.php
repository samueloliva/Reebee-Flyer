<?php
require('vendor/autoload.php');

class UserTest extends PHPUnit_Framework_TestCase {
    protected $client;

    protected function setUp() {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080'
        ]);
    }

    public function testPost_NewUser_UserObject() {
        $flyerId = uniqid();

        $response = $this->client->post('/user', [
            'json' => [
                'name' => 'Jose Silva', 
                'username' => 'jose.silva', 
                'password' => '54321'
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertEquals($bookId, $data['id']);
    } 
}