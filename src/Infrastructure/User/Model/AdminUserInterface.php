<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AdminUserInterface as DomainAdminUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface, SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
}
