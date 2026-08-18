<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Application;

use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Component\Core\Domain\Factory\AdminUserFactoryInterface;
use CongregationManager\Component\Core\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;

final readonly class CreateAdminUser
{
    /**
     * @phpstan-param AdminUserRepositoryInterface<covariant AdminUserInterface> $adminUserRepository
     * @psalm-param AdminUserRepositoryInterface<AdminUserInterface> $adminUserRepository
     */
    public function __construct(
        private AdminUserFactoryInterface $adminUserFactory,
        private AdminUserRepositoryInterface $adminUserRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(
        string $email,
        ?string $plainPassword = null,
        ?string $localeCode = null
    ): AdminUserInterface {
        $adminUser = $this->adminUserFactory->createNew($email, null, $localeCode);
        if ($plainPassword !== null) {
            $adminUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $adminUser));
        }
        $this->adminUserRepository->add($adminUser);

        return $adminUser;
    }
}
