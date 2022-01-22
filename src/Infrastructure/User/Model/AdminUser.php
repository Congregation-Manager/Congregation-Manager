<?php


namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AdminUser as DomainAdminUser;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as SymfonyUserInterface;

class AdminUser extends DomainAdminUser implements SymfonyUserInterface, PasswordAuthenticatedUserInterface
{
    use SymfonyUserTrait;
}
