<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\UserInterface as DomainUserInterface;

interface UserInterface extends DomainUserInterface
{
    /**
     * @return string[]
     */
    public function getRoles(): array;

    public function setRoles(array $roles): void;
}
