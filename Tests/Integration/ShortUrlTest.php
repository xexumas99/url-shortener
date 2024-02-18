<?php

namespace App\Tests\Integration;

use PHPUnit\Framework\TestCase;

class ShortUrlTest extends TestCase
{
    protected $endpoint;
    protected $client;

    protected function setUp(): void
    {
        $this->client = new \GuzzleHttp\Client();
        $this->endpoint = 'http://localhost:8000/api/v1/short-urls';

        parent::setUp();
    }

    public function testShortUrlSuccess(): void
    {
        $response = $this->client->post($this->endpoint, [
            'headers' => [
                'Authorization' => 'Bearer {[]}',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode(['url' => 'https://www.google.com']),
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($response->getBody());
        $this->assertStringContainsString('tinyurl.com', $response->getBody());
    }

    public function testShortUrlUnauthorized(): void
    {
        try {
            $this->client->post($this->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer {[]}}',
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(['url' => 'https://www.google.com']),
            ]);

            $this->fail('Expected 401 HTTP status code');
        } catch (\Exception $e) {
            $this->assertEquals(401, $e->getCode());

            $response = json_decode($e->getResponse()->getBody(), true);
            $this->assertEquals('Unauthorized',  $response['error']);
        }
    }

    public function testShortUrlBadUrl(): void
    {
        try {
            $this->client->post($this->endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer {[]}',
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode(['url' => 'google.com']),
            ]);

            $this->fail('Expected 400 HTTP status code');
        } catch (\Exception $e) {
            $this->assertEquals(400, $e->getCode());

            $response = json_decode($e->getResponse()->getBody(), true);
            $this->assertEquals('Invalid URL',  $response['error']);
        }
    }
}
