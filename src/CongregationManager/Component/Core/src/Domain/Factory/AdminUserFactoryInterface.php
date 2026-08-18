<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\AdminUserInterface;

interface AdminUserFactoryInterface
{
    public function createNew(
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AdminUserInterface;
}
