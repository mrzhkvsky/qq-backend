<?php
declare(strict_types=1);

namespace App\Application\EventSubscriber;

use App\Infrastructure\Rpc\Exception\RpcAuthenticationException;
use App\Infrastructure\Rpc\Exception\RpcInvalidRequestException;
use JetBrains\PhpStorm\ArrayShape;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTInvalidEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Serializer\SerializerInterface;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[ArrayShape([
        'lexik_jwt_authentication.on_authentication_failure' => "string",
        'lexik_jwt_authentication.on_jwt_invalid' => "string",
        'lexik_jwt_authentication.on_jwt_not_found' => "string",
        'lexik_jwt_authentication.on_jwt_expired' => "string"])
    ]
    public static function getSubscribedEvents(): array
    {
        return [
            'lexik_jwt_authentication.on_authentication_failure' => 'onAuthenticationFailure',
            'lexik_jwt_authentication.on_jwt_invalid' => 'onJWTInvalid',
            'lexik_jwt_authentication.on_jwt_not_found' => 'onJWTNotFound',
            'lexik_jwt_authentication.on_jwt_expired' => 'onJWTExpired'
        ];
    }

    public function onAuthenticationFailure(AuthenticationFailureEvent $event): void
    {
        if ($event->getException() instanceof BadCredentialsException) {
            $data = $this->serializer->serialize(
                new RpcInvalidRequestException('Bad credentials'),
                'json'
            );

            $event->setResponse(JsonResponse::fromJsonString($data));
        }

        throw $event->getException();
    }

    public function onJWTInvalid(JWTInvalidEvent $event): void
    {
        $data = $this->serializer->serialize(
            new RpcAuthenticationException('Your token is invalid, please login again to get a new one'),
            'json'
        );

        $event->setResponse(JsonResponse::fromJsonString($data));
    }


    public function onJWTNotFound(JWTNotFoundEvent $event): void
    {
        $data = $this->serializer->serialize(
            new RpcAuthenticationException('Missing token'),
            'json'
        );

        $event->setResponse(JsonResponse::fromJsonString($data));
    }

    public function onJWTExpired(JWTExpiredEvent $event): void
    {
        $data = $this->serializer->serialize(
            new RpcAuthenticationException('Your token is expired, please renew it'),
            'json'
        );

        $event->setResponse(JsonResponse::fromJsonString($data));
    }
}
