<?php
declare(strict_types=1);

namespace App\Application\EventSubscriber;

use App\Infrastructure\Rpc\Exception\RpcAuthenticationException;
use App\Infrastructure\Rpc\Exception\RpcInternalErrorException;
use App\Infrastructure\Rpc\Exception\RpcInvalidParamsException;
use Gesdinet\JWTRefreshTokenBundle\Security\Authenticator\RefreshTokenAuthenticator;
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
        $exception = $event->getException();

        if ($exception instanceof BadCredentialsException) {
            throw new RpcInvalidParamsException([]);
        }

        if ($exception->getTrace()[0]['class'] === RefreshTokenAuthenticator::class) {
            throw new RpcInvalidParamsException([]);
        }

        throw new RpcInternalErrorException($exception);
    }

    public function onJWTInvalid(JWTInvalidEvent $event)
    {
        throw new RpcAuthenticationException('Your token is invalid, please login again to get a new one');
    }

    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        throw new RpcAuthenticationException('Missing token');
    }

    public function onJWTExpired(JWTExpiredEvent $event)
    {
        throw new RpcAuthenticationException('Your token is expired, please renew it');
    }
}
