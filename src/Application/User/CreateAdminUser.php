<?php

declare(strict_types=1);

namespace CongregationManager\Application\User;

use CongregationManager\Domain\User\Hasher\UserPasswordHasherInterface;
use CongregationManager\Domain\User\Model\AdminUser;
use CongregationManager\Domain\User\Model\AdminUserInterface;
use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;

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
        if (null !== $plainPassword) {
            $adminUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $adminUser));
        }
        $this->adminUserRepository->add($adminUser);

        return $adminUser;
    }
}
