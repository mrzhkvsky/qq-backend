<?php
declare(strict_types=1);

namespace App\Domain\User\Data;

use App\Domain\User\Enum\GenderEnum;

class CreateUserData
{
    public string $id;
    public string $email;
    public string $firstName;
    public string $lastName;
    public string $password;
    public GenderEnum $gender;

    public function __construct(string $id, string $email, string $firstName, string $lastName, string $password, GenderEnum $gender)
    {
        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->gender = $gender;
    }
}
