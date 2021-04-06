<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;

class RpcAuthenticationException extends RpcException
{
    #[Pure] public function __construct(string $message = 'Authentication error')
    {
        parent::__construct(self::AUTHENTICATION_ERROR, $message);
    }
}
