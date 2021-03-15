<?php
declare(strict_types=1);

namespace App\Application\EventSubscruber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticationSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_authentication_failure' => [
                ['onAuthenticationFailure', 0]
            ]
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        $data = [
            'message' => 'Bad credentials, please verify that your email/password are correctly set',
        ];

        $response = new JsonResponse($data, JsonResponse::HTTP_BAD_REQUEST);

        $event->setResponse($response);
    }
}
