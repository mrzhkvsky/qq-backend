<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Model;

class RpcCallResponse
{
    private bool $isBatch;
    /** @var \App\Infrastructure\Rpc\Model\RpcResponse[] */
    private array $responseList = [];

    public function __construct(bool $isBatch)
    {
        $this->isBatch = $isBatch;
    }

    public function isBatch(): bool
    {
        return $this->isBatch;
    }

    public function getResponseList(): array
    {
        return $this->responseList;
    }

    public function addResponse(RpcResponse $response): void
    {
        $this->responseList[] = $response;
    }
}
