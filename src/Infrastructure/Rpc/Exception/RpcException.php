<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

class RpcException extends \Exception implements RpcExceptionInterface
{
    private array $data;

    public function __construct(int $code, string $message = '', array $data = [])
    {
        $this->data = $data;

        parent::__construct($message, $code);
    }

    public function getErrorCode(): int
    {
        return parent::getCode();
    }

    public function getErrorMessage(): string
    {
        return parent::getMessage();
    }

    public function getErrorData(): array
    {
        return $this->data;
    }
}
