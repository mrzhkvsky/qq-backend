<?php
declare(strict_types=1);

namespace App\Infrastructure\Rpc\Interface;

use Symfony\Component\Validator\Constraint;

interface MethodWithValidatedParamsInterface
{
    public function getParamsConstraint(): Constraint;
}
