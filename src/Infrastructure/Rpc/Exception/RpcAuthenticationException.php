<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

class RpcAuthenticationException extends RpcException
{
    public function __construct(string $message)
    {
        parent::__construct(self::AUTHENTICATION_ERROR, $message);
    }
}
