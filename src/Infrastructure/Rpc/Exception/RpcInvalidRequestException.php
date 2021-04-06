<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;

class RpcInvalidRequestException extends RpcException
{
    #[Pure]
    public function __construct(string $message = 'Invalid Request')
    {
        parent::__construct(
            self::INVALID_REQUEST,
            $message
        );
    }
}
