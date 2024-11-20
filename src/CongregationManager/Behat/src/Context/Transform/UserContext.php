<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Bundle\Core\Entity\AdminUser;
use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;

final readonly class UserContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @Transform :appUser
     * @Transform /^app user "([^"]+)"$/
     */
    public function getAppUserByEmail(string $email): AppUIUserInterface
    {
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
