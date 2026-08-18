<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use Webmozart\Assert\Assert;

trait SymfonyUserTrait
{
    /**
     * @return non-empty-string
     */
    public function getUserIdentifier(): string
    {
        Assert::stringNotEmpty($this->email);

        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
