<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\User\Enum\RoleEnum;

class RoleEnumType extends PhpEnumType
{
    protected string $name = 'role_enum';
    protected string $enumClass = RoleEnum::class;
}
