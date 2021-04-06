<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Model;

use App\Infrastructure\Rpc\Exception\RpcExceptionInterface;
use JetBrains\PhpStorm\Pure;

class RpcResponse
{
    private string $jsonrpc;
    private mixed $result = null;
    private ?RpcExceptionInterface $error = null;
    private int|string|null $id = null;
    private bool $isNotification = false;

    public function __construct(string $jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
    }

    public function getJsonrpc(): string
    {
        return $this->jsonrpc;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }

    public function setResult(mixed $result): RpcResponse
    {
        $this->result = $result;

        return $this;
    }

    public function getError(): ?RpcExceptionInterface
    {
        return $this->error;
    }

    public function setError(RpcExceptionInterface $error): RpcResponse
    {
        $this->error = $error;

        return $this;
    }

    public function getId(): int|string|null
    {
        return $this->id;
    }

    public function setId(int|string|null $id): RpcResponse
    {
        $this->id = $id;

        return $this;
    }

    public function isNotification(): bool
    {
        return $this->isNotification;
    }

    public function setIsNotification(bool $isNotification): RpcResponse
    {
        $this->isNotification = $isNotification;

        return $this;
    }
}
