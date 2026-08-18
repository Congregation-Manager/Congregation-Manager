<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\AdminUser;
use CongregationManager\Component\Core\Domain\AdminUserInterface;

final class AdminUserFactory implements AdminUserFactoryInterface
{
    #[\Override]
    public function createNew(
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AdminUserInterface {
        return new AdminUser($email, $password, $localeCode);
    }
}
