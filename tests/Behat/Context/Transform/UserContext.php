<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\User\Model\AdminUserInterface;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Infrastructure\User\Model\AppUser;
use CongregationManager\Infrastructure\User\Model\AppUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

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
    public function getAppUserByEmail(string $email): AppUserInterface
    {
        /** @var AppUserInterface $appUser */
        $appUserRepository = $this->entityManager->getRepository(AppUser::class);
        $appUser = $appUserRepository->findOneBy(['email' => $email]);
        if (null === $appUser) {
            throw new InvalidArgumentException(sprintf('App user with email "%s" does not exist.', $email));
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
            $adminUser = new AdminUser($email);

            $this->entityManager->persist($adminUser);
            $this->entityManager->flush();
        }

        return $adminUser;
    }
}
