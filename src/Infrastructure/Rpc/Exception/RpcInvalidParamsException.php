<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

class RpcInvalidParamsException extends RpcException
{
    private array $violationList;

    public function __construct(array $violationList)
    {
        $this->violationList = $violationList;

        parent::__construct(
            self::INVALID_PARAMS,
            'Invalid params',
            $violationList
        );
    }

    public function getViolationList(): array
    {
        return $this->violationList;
    }
}
