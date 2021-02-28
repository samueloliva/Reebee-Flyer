<?php
require('vendor/autoload.php');

class FlyrTest extends PHPUnit_Framework_TestCase {
    protected $client;

    protected function setUp() {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8080'
        ]);
    }

    public function testGet_ValidInput_FlyerObject() {
        $response = $this->client->get('/flyer/2');
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('store_name', $data);
        $this->assertArrayHasKey('date_valid', $data);
        $this->assertArrayHasKey('date_expired', $data);
        $this->assertArrayHasKey('page_count', $data);
        $this->assertEquals('2021-05-20', $data['date_valid']);

    }

    public function testPost_NewFlyer_FlyerObject() {
        $flyerId = uniqid();

        $response = $this->client->post('/flyer', [
            'json' => [
                'id' => $flyerId,
                'name' => 'My Flyer Test',
                'store_name' => 'Test Store',
                'date_valid' => '2021-08-02',
                'date_expired' => '2021-09-02',
                'page_count' => 1
            ]
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $data = json_decode($response->getBody(), true);
        $this->assertEquals($bookId, $data['id']);
    }
}