<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Repository;

use CongregationManager\Component\User\Domain\AdminUserInterface;

interface AdminUserRepositoryInterface
{
    public function add(AdminUserInterface $adminUser): void;
}
