<?php
require('vendor/autoload.php');

class PageTest extends PHPUnit_Framework_TestCase {
    protected $client;

    protected function setUp() {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080'
        ]);
    }

    public function testGet_ValidInput_PageObject() {
        $response = $this->client->get('/page/flyer/2');
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true)[0];
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('date_valid', $data);
        $this->assertArrayHasKey('date_expired', $data);
        $this->assertArrayHasKey('page_number', $data);
        $this->assertArrayHasKey('flyer_id', $data);
    }

    public function testPost_NewPage_PageObject() {
        $flyerId = uniqid();

        $response = $this->client->post('/page', [
            'json' => [
                "dateValid" => "2021-03-10",
                "dateExpired" => "2021-03-14",
                "pageNumber" => 1,
                "flyerId" => 5
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertEquals($bookId, $data['id']);
    } 
}