<?php

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\UserInterface as DomainUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UserInterface extends DomainUserInterface, SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @return string[]
     */
    public function getRoles(): array;

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void;
}
