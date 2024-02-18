<?php

namespace App\Controller;

use App\Helper\BearerTokenHelper;
use App\Helper\ValidationHelper;
use App\Service\ShortUrlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShortUrlController extends AbstractController
{

    protected ShortUrlService $shortUrlService;

    public function __construct()
    {
        $this->shortUrlService = new ShortUrlService();
    }

    #[Route("/api/v1/short-urls", name: "short_url", methods: ['POST'])]
    public function createShortUrl(Request $request): Response
    {
        try {
            $token = $request->headers->get('Authorization');

            $isTokenValid = BearerTokenHelper::isBearerTokenValid($token);

            if (!$isTokenValid) {
                return $this->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }

            $body = json_decode($request->getContent(), true);

            $originalUrl = $body['url'] ?? '';

            if (empty($originalUrl)) {
                return $this->json(['error' => 'URL is required'], Response::HTTP_BAD_REQUEST);
            }

            if (!ValidationHelper::isValidUrl($originalUrl)) {
                return $this->json(['error' => 'Invalid URL'], Response::HTTP_BAD_REQUEST);
            }

            $new_url = $this->shortUrlService->getShortUrl($originalUrl);

            return $this->json(['url' => $new_url]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
