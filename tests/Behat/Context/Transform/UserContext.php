<?php

declare(strict_types=1);

namespace App\Tests\Behat\Context\Transform;

use App\Domain\User\Model\AdminUserInterface;
use App\Infrastructure\User\Model\AdminUser;
use App\Infrastructure\User\Model\AppUser;
use App\Infrastructure\User\Model\AppUserInterface;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;

final class UserContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @Transform :appUser
     * @Transform /^app user "([^"]+)"$/
     */
    public function getOrCreateAppUserByEmail(string $email): AppUserInterface
    {
        /** @var AppUserInterface $appUser */
        $appUserRepository = $this->entityManager->getRepository(AppUser::class);
        $appUser = $appUserRepository->findOneBy(['email' => $email]);
        if (null === $appUser) {
            $appUser = AppUser::create($email);

            $this->entityManager->persist($appUser);
            $this->entityManager->flush();
        }

        return $appUser;
    }

    /**
     * @Transform :adminUser
     * @Transform /^admin user "([^"]+)"$/
     */
    public function getOrCreateAdminUserByEmail(string $email): AdminUserInterface
    {
        /** @var AdminUserInterface $adminUser */
        $adminUserRepository = $this->entityManager->getRepository(AdminUser::class);
        $adminUser = $adminUserRepository->findOneBy(['email' => $email]);
        if (null === $adminUser) {
            $adminUser = AdminUser::create($email);

            $this->entityManager->persist($adminUser);
            $this->entityManager->flush();
        }

        return $adminUser;
    }
}
