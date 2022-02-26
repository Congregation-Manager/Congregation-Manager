<?php


namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\AppUser as DomainAppUser;

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
