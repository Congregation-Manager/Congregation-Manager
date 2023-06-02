<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Infrastructure\InMemory\Repository;

use CongregationManager\Component\User\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\Repository\AdminUserRepositoryInterface;

final class AdminUserRepository implements AdminUserRepositoryInterface
{
    /**
     * @var AdminUserInterface[]
     */
    public array $adminUsers = [];

    public function add(AdminUserInterface $adminUser): void
    {
        if (in_array($adminUser, $this->adminUsers, true)) {
            return;
        }

        $this->adminUsers[] = $adminUser;
    }
}
