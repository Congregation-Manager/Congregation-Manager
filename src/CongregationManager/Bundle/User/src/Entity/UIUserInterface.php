<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\UIUserInterface as DomainUIUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface UIUserInterface extends DomainUIUserInterface, SymfonyUserInterface, PasswordAuthenticatedUserInterface
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
