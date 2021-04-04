<?php
declare(strict_types=1);

namespace App\Domain\User\Service;

use App\Domain\User\Data\CreateUserData;
use App\Domain\User\Entity\User;
use App\Infrastructure\PersistManager;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private PersistManager $pm;
    private UserPasswordEncoderInterface $passwordEncoder;

    /**
     * @param \App\Infrastructure\PersistManager $pm
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(PersistManager $pm, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->pm = $pm;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser(CreateUserData $data): void
    {
        $user = new User(
            $data->email,
            $data->firstName,
            $data->lastName,
            $data->gender
        );

        $encodedPassword = $this->passwordEncoder->encodePassword($user, $data->password);

        $user->changePassword($encodedPassword);

        $this->pm->persist($user);
        $this->pm->flush();
    }
}
