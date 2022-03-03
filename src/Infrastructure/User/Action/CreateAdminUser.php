<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Action;

use CongregationManager\Domain\User\Hasher\UserPasswordHasherInterface;
use CongregationManager\Domain\User\Repository\AdminUserRepositoryInterface;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Infrastructure\User\Model\AdminUserInterface;

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
