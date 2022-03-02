<?php

namespace CongregationManager\Domain\User\Repository;

use CongregationManager\Domain\User\Model\AdminUserInterface;

interface AdminUserRepositoryInterface
{
    public function add(AdminUserInterface $adminUser): void;
}
