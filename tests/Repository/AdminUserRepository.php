<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Component\User\Domain\AdminUser;
use CongregationManager\Component\User\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\Repository\AdminUserRepositoryInterface;

final class AdminUserRepository extends InMemoryRepository implements AdminUserRepositoryInterface
{
    public function add(AdminUserInterface $adminUser): void
    {
        $this->objectCollection->add($adminUser);
    }

    public function getClassName(): string
    {
        return AdminUser::class;
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
