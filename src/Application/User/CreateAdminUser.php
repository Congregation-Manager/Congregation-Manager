<?php

declare(strict_types=1);

namespace CongregationManager\Application\User;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\User\Model\AdminUser;
use CongregationManager\Domain\User\Model\AdminUserInterface;
use CongregationManager\Domain\User\Model\AppUser;
use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;
use CongregationManager\Domain\User\Repository\AppUserRepositoryInterface;

final class CreateAdminUser
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository
    ) {
    }

    public function create(
        string $email,
        ?string $password = null,
        ?string $localeCode = null
    ): AdminUserInterface {
        $adminUser = new AdminUser($email, $password, $localeCode);
        $this->adminUserRepository->add($adminUser);

        return $adminUser;
    }
}
