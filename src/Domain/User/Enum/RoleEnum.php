<?php
declare(strict_types=1);

namespace App\Domain\User\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static RoleEnum ADMIN()
 * @method static RoleEnum USER()
 */
final class RoleEnum extends Enum
{
    private const ADMIN = 'ROLE_ADMIN';
    private const USER = 'ROLE_USER';
}
