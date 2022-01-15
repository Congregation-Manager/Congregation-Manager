<?php

namespace App\Tests\Behat\Context\Setup;

use App\Domain\User\Model\AdminUser;
use App\Domain\User\Model\AppUser;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AccountContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    /**
     * @Given there is an app user with email :email and password :password
     */
    public function thereIsAnAppUserWithEmailAndPassword(string $email, string $password): void
    {
        $appUser = new AppUser($email);
        $appUser->setPassword($this->userPasswordHasher->hashPassword($appUser, $password));

        $this->entityManager->persist($appUser);
        $this->entityManager->flush();
    }

    /**
     * @Given there is an admin user with email :email and password :password
     */
    public function thereIsAnAdminUserWithEmailAndPassword(string $email, string $password): void
    {
        $adminUser = new AdminUser($email);
        $adminUser->setPassword($this->userPasswordHasher->hashPassword($adminUser, $password));

        $this->entityManager->persist($adminUser);
        $this->entityManager->flush();
    }
}
