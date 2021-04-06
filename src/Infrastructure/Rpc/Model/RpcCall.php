<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Model;

class RpcCall
{
    private bool $isBatch;
    /** @var array<\App\Infrastructure\Rpc\Model\RpcRequest|\Exception> */
    private array $requestList = [];

    public function __construct(bool $isBatch = false)
    {
        $this->isBatch = $isBatch;
    }

    public function isBatch(): bool
    {
        return $this->isBatch;
    }

    public function getRequestList(): array
    {
        return $this->requestList;
    }

    public function addRequest(\Exception|RpcRequest $request): RpcCall
    {
        $this->requestList[] = $request;

        return $this;
    }
}
