<?php
declare(strict_types=1);

namespace App\Infrastructure;

use App\Domain\User\Entity\User;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    public function getUser(): User
    {
        /** @var User $user */
        $user = parent::getUser();

        if (is_null($user)) {
            throw new \Exception('User is not authorized');
        }

        return $user;
    }
}
