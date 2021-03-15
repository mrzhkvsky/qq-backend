<?php
declare(strict_types=1);

namespace App\Application;

trait UserSecurity
{
    public function getRoles(): array
    {
        return [$this->getRole()->getValue()];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
    }
}
