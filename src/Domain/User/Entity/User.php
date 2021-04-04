<?php
declare(strict_types=1);

namespace App\Domain\User\Entity;

use App\Application\UserSecurityTrait;
use App\Domain\User\Enum\GenderEnum;
use App\Domain\User\Enum\RoleEnum;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
    use UserSecurityTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string")
     */
    private string $email;

    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string")
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private string $lastName;

    /**
     * @ORM\Column(type="gender_enum")
     */
    private GenderEnum $gender;

    /**
     * @ORM\Column(type="role_enum")
     */
    private RoleEnum $role;

    public function __construct(string $email, string $firstName, string $lastName, GenderEnum $gender)
    {
        $this->setEmail($email)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setGender($gender)
            ->setRole(RoleEnum::USER());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function changeEmail(string $email): User
    {
        return $this->setEmail($email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function changePassword(string $password): User
    {
        return $this->setPassword($password);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function changeFirstName(string $firstName): User
    {
        return $this->setFirstName($firstName);
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function changeLastName(string $lastName): User
    {
        return $this->setLastName($lastName);
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function changeGender(GenderEnum $gender): User
    {
        return $this->setGender($gender);
    }

    public function getRole(): RoleEnum
    {
        return $this->role;
    }

    private function changeRole(RoleEnum $role): User
    {
        return $this->setRole($role);
    }

    private function setId(string $id): User
    {
        Assert::uuid($id);
        $this->id = $id;

        return $this;
    }

    private function setEmail(string $email): User
    {
        Assert::email($email);
        $this->email = $email;

        return $this;
    }

    private function setFirstName(string $firstName): User
    {
        Assert::lengthBetween($firstName, 2, 20);
        $this->firstName = $firstName;

        return $this;
    }

    private function setLastName(string $lastName): User
    {
        Assert::lengthBetween($lastName, 2, 20);
        $this->lastName = $lastName;

        return $this;
    }

    private function setGender(GenderEnum $gender): User
    {
        $this->gender = $gender;

        return $this;
    }

    private function setRole(RoleEnum $role): User
    {
        $this->role = $role;

        return $this;
    }
}
