<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AppUserInterface as DomainAppUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

interface AppUserInterface extends DomainAppUserInterface, UserInterface, SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
}
