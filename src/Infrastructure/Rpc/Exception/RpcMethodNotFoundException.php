<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;

class RpcMethodNotFoundException extends RpcException
{
    private string $methodName;

    #[Pure]
    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;

        parent::__construct(self::METHOD_NOT_FOUND, "Method `$methodName` not found");
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }
}
