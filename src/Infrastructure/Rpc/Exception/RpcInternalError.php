<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

class RpcInternalError extends RpcException
{
    public function __construct(\Throwable $previous = null)
    {
        parent::__construct(self::SERVER_ERROR, 'Internal error', is_null($previous) ? [] : [
            'message' => $previous->getMessage(),
            'file' => $previous->getFile(),
            'class' => get_class($previous),
            'line' => $previous->getLine(),
            'trace' => $previous->getTrace()
        ]);
    }
}
