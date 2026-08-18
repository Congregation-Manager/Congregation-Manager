<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Factory;

use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Component\Core\Domain\Factory\AdminUserFactoryInterface;

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
