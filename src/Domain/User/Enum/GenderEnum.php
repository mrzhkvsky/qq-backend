<?php
declare(strict_types=1);

namespace App\Domain\User\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static GenderEnum MALE()
 * @method static GenderEnum FEMALE()
 */
class GenderEnum extends Enum
{
    public const MALE = 'MALE';
    public const FEMALE = 'FEMALE';
}
