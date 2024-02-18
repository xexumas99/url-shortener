<?php

namespace App\EventListener;

use App\Helper\BearerTokenHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class BearerTokenValidationListener
{
    protected $protectedRoutes = ['short_url'];

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!in_array($request->attributes->get('_route'), $this->protectedRoutes)) {
            return;
        }

        $token = $request->headers->get('Authorization');
        $isTokenValid = BearerTokenHelper::isBearerTokenValid($token);

        if (!$isTokenValid) {
            $event->setResponse(new Response('Unauthorized', Response::HTTP_UNAUTHORIZED));
        }
    }
}
