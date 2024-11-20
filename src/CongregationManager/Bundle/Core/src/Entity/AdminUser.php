<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Bundle\User\Entity\SymfonyUserTrait;
use CongregationManager\Component\Core\Domain\AdminUser as DomainAdminUser;

class AdminUser extends DomainAdminUser implements AdminUIUserInterface
{
    use SymfonyUserTrait;

    public const string SUPER_ADMIN_ROLE = 'ROLE_SUPER_ADMIN';

    public const string ADMIN_ROLE = 'ROLE_ADMIN';

    /**
     * @var string[]
     */
    protected array $roles = [self::SUPER_ADMIN_ROLE, self::ADMIN_ROLE];
}
