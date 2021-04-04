<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use Throwable;

class RpcInternalErrorException extends RpcException
{
    private Throwable $previous;

    public function __construct(Throwable $previous)
    {
        $this->previous = $previous;

        parent::__construct(self::INTERNAL_ERROR, 'Internal server error', [
            'message' => $previous->getMessage(),
            'file' => $previous->getFile(),
            'class' => get_class($previous),
            'trace' => $previous->getTrace()
        ]);
    }
}
