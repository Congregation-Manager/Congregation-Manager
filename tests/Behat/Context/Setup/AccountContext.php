<?php

namespace App\Tests\Behat\Context\Setup;

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
        $user = new AppUser($email);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
