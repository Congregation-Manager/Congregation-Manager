<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Action;

use CongregationManager\Bundle\User\Entity\AdminUser;
use CongregationManager\Bundle\User\Entity\AdminUserInterface;
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
