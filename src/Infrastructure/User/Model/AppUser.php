<?php


namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AppUser as DomainAppUser;

class AppUser extends DomainAppUser implements AppUserInterface
{
    use SymfonyUserTrait;

    /** @var string[] */
    protected array $roles = ['ROLE_USER'];

    public static function create(string $email): AppUserInterface
    {
        return new self($email);
    }
}
