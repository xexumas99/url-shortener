<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;

class ShortUrlService
{
    protected $httpService;

    public function __construct()
    {
        $this->httpService = new HttpService();
    }

    public function getShortUrl(string $originalUrl): string
    {
        try {
            $response = $this->httpService->get('https://tinyurl.com/api-create.php', [
                'url' => $originalUrl
            ]);

            return $response;
        } catch (GuzzleException $e) {
            throw new \Exception("Error al realizar la solicitud GET: " . $e->getMessage());
        }
    }
}
