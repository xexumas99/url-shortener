<?php

namespace App\Controller;

use App\Helper\BearerTokenHelper;
use App\Helper\ValidationHelper;
use GuzzleHttp\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortUrlController extends AbstractController
{
    #[Route("/api/v1/short-urls", name: "short_url", methods: ['POST'])]
    public function createShortUrl(Request $request): Response
    {
        $token = $request->headers->get('Authorization');

        $isTokenValid = BearerTokenHelper::isBearerTokenValid($token);

        if (!$isTokenValid) {
            return $this->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $body = json_decode($request->getContent(), true);

        $originalUrl = $body['url'] ?? '';
        
        if (empty($originalUrl)) {
            return $this->json(['error' => 'URL is required'], Response::HTTP_BAD_REQUEST);
        }

        if (!ValidationHelper::isValidUrl($originalUrl)) {
            return $this->json(['error' => 'Invalid URL'], Response::HTTP_BAD_REQUEST);
        }

        $client = new Client();
        $response = $client->request('GET', 'https://tinyurl.com/api-create.php', [
            'query' => ['url' => $originalUrl]
        ]);

        $shortUrl = $response->getBody()->getContents();

        return $this->json(['url' => $shortUrl]);
    }
}
