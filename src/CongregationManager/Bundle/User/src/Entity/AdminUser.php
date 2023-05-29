<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\AdminUser as DomainAdminUser;

class AdminUser extends DomainAdminUser implements AdminUserInterface
{
    use SymfonyUserTrait;

    /**
     * @var string[]
     */
    protected array $roles = ['ROLE_ADMIN'];
}
