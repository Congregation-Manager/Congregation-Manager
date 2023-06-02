<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Application;

use CongregationManager\Component\User\Domain\AdminUser;
use CongregationManager\Component\User\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\Repository\AdminUserRepositoryInterface;

final class CreateAdminUser
{
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(
        string $email,
        ?string $plainPassword = null,
        ?string $localeCode = null
    ): AdminUserInterface {
        $adminUser = new AdminUser($email, null, $localeCode);
        if ($plainPassword !== null) {
            $adminUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $adminUser));
        }
        $this->adminUserRepository->add($adminUser);

        return $adminUser;
    }
}
