<?php

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Infrastructure\Common\Converter\LocaleConverterInterface;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Infrastructure\User\Model\AdminUserInterface;
use CongregationManager\Infrastructure\User\Model\AppUser;
use CongregationManager\Infrastructure\User\Model\AppUserInterface;
use CongregationManager\Infrastructure\User\Model\ResetPasswordRequest;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
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
        private ResetPasswordRequestRepositoryInterface $resetPasswordRequestRepository,
        private LocaleConverterInterface $localeConverter
    ) {
    }

    /**
     * @Given there is an app user with email :email
     * @Given there is an app user with email :email and password :password
     */
    public function thereIsAnAppUserWithEmailAndPassword(string $email, string $password = 'password'): void
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

    /**
     * @Given I have already received a resetting password email for :email brother
     */
    public function iHaveAlreadyReceivedAResettingPasswordEmailForBrother(string $email): void
    {
        $appUserRepository = $this->entityManager->getRepository(AppUser::class);
        $appUser = $appUserRepository->findOneBy(['email' => $email]);
        Assert::isInstanceOf($appUser, AppUserInterface::class);

        $expiresAt = new \DateTimeImmutable('tomorrow');
        $hashedVerifierToken = $this->tokenGenerator->createToken(
            $expiresAt,
            $this->resetPasswordRequestRepository->getUserIdentifier($appUser)
        );

        $resetPasswordRequest = new ResetPasswordRequest(
            $appUser,
            $expiresAt,
            $hashedVerifierToken->getSelector(),
            $hashedVerifierToken->getHashedToken()
        );
        $this->entityManager->persist($resetPasswordRequest);
        $this->entityManager->flush();

        $this->sharedStorage->set('forgot_password_token', $hashedVerifierToken->getPublicToken());
    }

    /**
     * @Given /^The (app user "[^"]+") has "([^"]*)" as preferred language$/
     */
    public function theAppUserHasAsPreferredLanguage(AppUserInterface $appUser, string $locale): void
    {
        $localeCode = $this->localeConverter->convertNameToCode($locale);
        $appUser->setLocaleCode($localeCode);
        $this->entityManager->flush();
    }

    /**
     * @Given /^The (admin user "[^"]+") has "([^"]*)" as preferred language$/
     */
    public function theAdminUserHasAsPreferredLanguage(AdminUserInterface $adminUser, string $locale): void
    {
        $localeCode = $this->localeConverter->convertNameToCode($locale);
        $adminUser->setLocaleCode($localeCode);
        $this->entityManager->flush();
    }
}
