<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use Throwable;

class RpcServerErrorException extends RpcException
{
    public function __construct(Throwable $previous)
    {
        parent::__construct(self::SERVER_ERROR, 'Server error', [
            'message' => $previous->getMessage(),
            'file' => $previous->getFile(),
            'class' => get_class($previous),
            'line' => $previous->getLine(),
            'trace' => $previous->getTrace()
        ]);
    }
}
