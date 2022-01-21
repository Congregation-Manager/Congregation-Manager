<?php


namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AdminUser as DomainAdminUser;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

class AdminUser extends DomainAdminUser implements SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
    /** @var string[] */
    protected array $roles = ['ROLE_ADMIN'];

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

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
