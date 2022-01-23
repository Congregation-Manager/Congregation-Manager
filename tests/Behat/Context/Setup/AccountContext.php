<?php

namespace App\Tests\Behat\Context\Setup;

use App\Infrastructure\User\Model\AdminUser;
use App\Infrastructure\User\Model\AdminUserInterface;
use App\Infrastructure\User\Model\AppUser;
use App\Infrastructure\User\Model\ResetPasswordRequest;
use App\Tests\Behat\Services\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\Generator\ResetPasswordTokenGenerator;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
        private ResetPasswordTokenGenerator $tokenGenerator,
        private SharedStorageInterface $sharedStorage,
        private ResetPasswordRequestRepositoryInterface $resetPasswordRequestRepository
    ) {
    }

    /**
     * @Given there is an app user with email :email and password :password
     */
    public function thereIsAnAppUserWithEmailAndPassword(string $email, string $password): void
    {
        $appUser = AppUser::create($email);
        $appUser->setPassword($this->userPasswordHasher->hashPassword($appUser, $password));

        $this->entityManager->persist($appUser);
        $this->entityManager->flush();
    }

    /**
     * @Given there is an admin user with email :email
     * @Given there is an admin user with email :email and password :password
     */
    public function thereIsAnAdminUserWithEmailAndPassword(string $email, string $password = 'password'): void
    {
        $adminUser = AdminUser::create($email);
        $adminUser->setPassword($this->userPasswordHasher->hashPassword($adminUser, $password));

        $this->entityManager->persist($adminUser);
        $this->entityManager->flush();
    }

    /**
     * @Given I have already received a resetting password email for :email administrator
     */
    public function iHaveAlreadyReceivedAResettingPasswordEmailForAdministrator(string $email): void
    {
        $adminUserRepository = $this->entityManager->getRepository(AdminUser::class);
        $adminUser = $adminUserRepository->findOneBy(['email' => $email]);
        Assert::isInstanceOf($adminUser, AdminUserInterface::class);

        $expiresAt = new \DateTimeImmutable('tomorrow');
        $fullToken = $this->getRandomString(40);
        $hashedVerifierToken = $this->tokenGenerator->createToken(
            $expiresAt,
            $this->resetPasswordRequestRepository->getUserIdentifier($adminUser)
        );

        $resetPasswordRequest = new ResetPasswordRequest(
            $adminUser,
            $expiresAt,
            $hashedVerifierToken->getSelector(),
            $hashedVerifierToken->getHashedToken()
        );
        $this->entityManager->persist($resetPasswordRequest);
        $this->entityManager->flush();

        $this->sharedStorage->set('forgot_password_token', $hashedVerifierToken->getPublicToken());
    }

    private function getRandomString(int $length = 5)
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $length);
    }
}
