<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use App\Domain\User\Enum\GenderEnum;

class GenderEnumType extends PhpEnumType
{
    protected string $name = 'gender_enum';
    protected string $enumClass = GenderEnum::class;
}
