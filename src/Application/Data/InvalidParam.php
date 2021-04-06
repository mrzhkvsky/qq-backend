<?php
declare(strict_types=1);

namespace App\Application\Data;

class InvalidParam
{
    private int $code;
    private string $message;
    private string $field;

    public function __construct(int $code, string $message, string $field)
    {
        $this->code = $code;
        $this->message = $message;
        $this->field = $field;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getField(): string
    {
        return $this->field;
    }
}
