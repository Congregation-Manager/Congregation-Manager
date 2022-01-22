<?php


namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AppUser as DomainAppUser;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

class AppUser extends DomainAppUser implements SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
    use SymfonyUserTrait;
}
