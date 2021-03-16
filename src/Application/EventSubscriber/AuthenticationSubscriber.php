<?php
declare(strict_types=1);

namespace App\Application\EventSubscriber;

use App\Application\Response\BadRequestResponse;
use App\Application\Response\UnauthorizedResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class AuthenticationSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_authentication_failure' => 'onAuthenticationFailure',
            'lexik_jwt_authentication.on_jwt_invalid' => 'onJWTInvalid',
            'lexik_jwt_authentication.on_jwt_not_found' => 'onJWTNotFound',
            'lexik_jwt_authentication.on_jwt_expired' => 'onJWTExpired'
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        if ($event->getException() instanceof BadCredentialsException) {
            $response = new BadRequestResponse(
                'Bad credentials, please verify that your email/password are correctly set'
            );
        } else {
            $response = new BadRequestResponse($event->getException()->getMessage());
        }

        $event->setResponse($response);
    }

    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        $response = new UnauthorizedResponse(
            'Your token is invalid, please login again to get a new one'
        );

        $event->setResponse($response);
    }

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $response = new UnauthorizedResponse(
            'Missing token'
        );

        $event->setResponse($response);
    }

    public function onJWTExpired(JWTExpiredEvent $event)
    {
        $response = new UnauthorizedResponse(
            'Your token is expired, please renew it.'
        );

        $event->setResponse($response);
    }
}
