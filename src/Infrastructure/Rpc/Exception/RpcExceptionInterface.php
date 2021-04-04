<?php

namespace App\Infrastructure\Rpc\Exception;

interface RpcExceptionInterface
{
    public const INTERNAL_ERROR = 1;
    public const INVALID_PARAMS = 2;
    public const METHOD_NOT_FOUND = 3;
    public const AUTHENTICATION_ERROR = 4;

    public function getErrorCode(): int;
    public function getErrorMessage(): string;
    public function getErrorData(): array;
}
