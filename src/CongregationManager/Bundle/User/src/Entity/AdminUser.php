<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\AdminUser as DomainAdminUser;

class AdminUser extends DomainAdminUser implements AdminUserInterface
{
    use SymfonyUserTrait;

    public const string SUPER_ADMIN_ROLE = 'ROLE_SUPER_ADMIN';

    public const string ADMIN_ROLE = 'ROLE_ADMIN';

    /**
     * @var string[]
     */
    protected array $roles = [self::SUPER_ADMIN_ROLE, self::ADMIN_ROLE];
}
