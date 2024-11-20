<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Action;

use CongregationManager\Bundle\Core\Entity\AdminUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Component\Core\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;

final readonly class CreateAdminUser
{
    /**
     * @phpstan-param AdminUserRepositoryInterface<covariant AdminUIUserInterface> $adminUserRepository
     * @psalm-param AdminUserRepositoryInterface<AdminUIUserInterface> $adminUserRepository
     */
    public function __construct(
        private AdminUserRepositoryInterface $adminUserRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(
        string $email,
        ?string $plainPassword = null,
        ?string $localeCode = null
    ): AdminUIUserInterface {
        $adminUser = new AdminUser($email, null, $localeCode);
        if ($plainPassword !== null) {
            $adminUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $adminUser));
        }
        $this->adminUserRepository->add($adminUser);

        return $adminUser;
    }
}
