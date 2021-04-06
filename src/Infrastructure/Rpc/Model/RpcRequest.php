<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Model;

use App\Infrastructure\Rpc\Exception\RpcInternalError;

class RpcRequest
{
    private const VERSION = '2.0';

    private string $jsonrpc;
    private string $method;
    private ?array $params = null;
    private int|string|null $id = null;
    private bool $isNotification = false;

    public function __construct(string $jsonrpc, string $method)
    {
        if ($jsonrpc !== self::VERSION) {
            throw new RpcInternalError();
        }

        $this->jsonrpc = $jsonrpc;
        $this->method = $method;
    }

    public function getJsonrpc(): string
    {
        return $this->jsonrpc;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParams(): ?array
    {
        return $this->params;
    }

    public function setParams(array $params): RpcRequest
    {
        $this->params = $params;

        return $this;
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(int|string $id): RpcRequest
    {
        $this->id = $id;

        return $this;
    }

    public function isNotification(): bool
    {
        return $this->isNotification;
    }

    public function setIsNotification(bool $isNotification): RpcRequest
    {
        $this->isNotification = $isNotification;

        return $this;
    }
}
