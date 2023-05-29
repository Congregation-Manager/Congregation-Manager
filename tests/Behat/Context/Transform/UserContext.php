<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Bundle\User\Entity\AdminUser;
use CongregationManager\Bundle\User\Entity\AppUser;
use CongregationManager\Bundle\User\Entity\AppUserInterface;
use CongregationManager\Component\User\Domain\AdminUserInterface;
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
        $appUser = $appUserRepository->findOneBy([
            'email' => $email,
        ]);
        if ($appUser === null) {
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
        $adminUser = $adminUserRepository->findOneBy([
            'email' => $email,
        ]);
        if ($adminUser === null) {
            $adminUser = new AdminUser($email);

            $this->entityManager->persist($adminUser);
            $this->entityManager->flush();
        }

        return $adminUser;
    }
}
