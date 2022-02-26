<?php


namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\AdminUser as DomainAdminUser;

class AdminUser extends DomainAdminUser implements AdminUserInterface
{
    use SymfonyUserTrait;

    /** @var string[] */
    protected array $roles = ['ROLE_ADMIN'];

    public static function create(string $email): AdminUserInterface
    {
        return new self($email);
    }
}
