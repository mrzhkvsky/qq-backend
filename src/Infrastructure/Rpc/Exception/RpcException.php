<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;

class RpcException extends \Exception implements RpcExceptionInterface
{
    private array $data;

    #[Pure]
    public function __construct(int $code, string $message = '', array $data = [])
    {
        $this->data = $data;

        parent::__construct($message, $code);
    }

    #[Pure]
    public function getErrorCode(): int
    {
        return parent::getCode();
    }

    #[Pure]
    public function getErrorMessage(): string
    {
        return parent::getMessage();
    }

    public function getErrorData(): array
    {
        return $this->data;
    }
}
