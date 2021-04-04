<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc;

class RpcResult
{
    public const SINGLE = 'single';
    public const COLLECTION = 'collection';

    private $data;
    private ?int $count;
    private string $type;

    public function __construct($data, int $count = null, string $type = self::SINGLE)
    {
        $this->data = $data;
        $this->count = $count;
        $this->type = $type;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
