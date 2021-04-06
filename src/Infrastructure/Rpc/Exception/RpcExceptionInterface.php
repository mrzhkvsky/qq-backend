<?php

namespace App\Infrastructure\Rpc\Exception;

interface RpcExceptionInterface
{
    public const PARSE_ERROR = -32700;
    public const INVALID_REQUEST = -32600;
    public const METHOD_NOT_FOUND = -32601;
    public const INVALID_PARAMS = -326002;
    public const INTERNAL_ERROR = -32603;
    public const SERVER_ERROR = -32603;
    public const AUTHENTICATION_ERROR = 4;

    public function getErrorCode(): int;
    public function getErrorMessage(): string;
    public function getErrorData(): array;
}
