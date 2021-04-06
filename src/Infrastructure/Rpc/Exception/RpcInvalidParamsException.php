<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Exception;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class RpcInvalidParamsException extends RpcException
{
    private ConstraintViolationListInterface $violationList;

    #[Pure]
    public function __construct(ConstraintViolationListInterface $violationList)
    {
        $this->violationList = $violationList;

        parent::__construct(
            self::INVALID_PARAMS,
            'Invalid params'
        );
    }

    public function getViolationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
