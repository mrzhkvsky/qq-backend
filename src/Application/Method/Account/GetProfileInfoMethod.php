<?php
declare(strict_types=1);

namespace App\Application\Method\Account;

use App\Application\Method\AbstractMethod;
use App\Domain\User\Entity\User;
use App\Infrastructure\Rpc\Interface\MethodInterface;

final class GetProfileInfoMethod extends AbstractMethod implements MethodInterface
{
    public function exec(?array $params): User
    {
        return $this->getUser();
    }
}
