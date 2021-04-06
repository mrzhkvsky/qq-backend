<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Model;

class RpcResult
{
    private mixed $result;
    private ?array $attributes;
    private ?array $ignoredAttributes;

    public function __construct(mixed $result, array $attributes = null, array $ignoredAttributes = null)
    {
        $this->result = $result;
        $this->attributes = $attributes;
        $this->ignoredAttributes = $ignoredAttributes;
    }

    public function getResult(): mixed
    {
        return $this->result;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function getIgnoredAttributes(): ?array
    {
        return $this->ignoredAttributes;
    }
}
