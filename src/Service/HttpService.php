<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function get(string $url, array $queryParams = []): string
    {
        try {
            $response = $this->client->request('GET', $url, [
                'query' => $queryParams
            ]);

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new \Exception("Error al realizar la solicitud GET: " . $e->getMessage());
        }
    }
}
