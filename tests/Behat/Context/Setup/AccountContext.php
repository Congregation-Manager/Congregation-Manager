<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Bundle\Core\Converter\LocaleConverterInterface;
use CongregationManager\Bundle\User\Action\CreateAppUserInvitation;
use CongregationManager\Bundle\User\Entity\AdminUser;
use CongregationManager\Bundle\User\Entity\AdminUserInterface;
use CongregationManager\Bundle\User\Entity\AppUser;
use CongregationManager\Bundle\User\Entity\AppUserInterface;
use CongregationManager\Bundle\User\Entity\ResetPasswordRequest;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Tests\Behat\Services\SecurityService;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use DateTimeImmutable;
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
        private LocaleConverterInterface $localeConverter,
        private CreateAppUserInvitation $createAppUserInvitation,
        private SecurityService $appSecurityService,
    ) {
    }

    /**
     * @Given /^the (brother|sister) has an account for email "([^"]*)"$/
     * @Given /^the (brother|sister) has an account for email "([^"]*)" and password "([^"]*)"$/
     */
    public function thereIsAnAppUserWithEmailAndPassword(
        string $type,
        string $email,
        string $password = 'password'
    ): void {
        /** @var ?BrotherInterface $brother */
        $brother = $this->sharedStorage->get('brother');
        Assert::isInstanceOf($brother, BrotherInterface::class);
        $appUser = new AppUser($brother, $email);
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
        $adminUser = new AdminUser($email);
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
        $adminUser = $adminUserRepository->findOneBy([
            'email' => $email,
        ]);
        Assert::isInstanceOf($adminUser, AdminUserInterface::class);

        $expiresAt = new DateTimeImmutable('tomorrow');
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
        $appUser = $appUserRepository->findOneBy([
            'email' => $email,
        ]);
        Assert::isInstanceOf($appUser, AppUserInterface::class);

        $expiresAt = new DateTimeImmutable('tomorrow');
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

    /**
     * @Given I have already received an invitation email for :email
     */
    public function iHaveAlreadyReceivedAnInviteEmailForBrother(string $email): void
    {
        /** @var BrotherInterface $brother */
        $brother = $this->sharedStorage->get('brother');
        $appUserInvitation = $this->createAppUserInvitation->create($brother, $email);

        $this->entityManager->persist($appUserInvitation);
        $this->entityManager->flush();

        $this->sharedStorage->set('invitation_app_token', $appUserInvitation->getToken());
    }

    /**
     * @Given I am logged in as :brother
     */
    public function iAmLoggedInAs(BrotherInterface $brother): void
    {
        $appUser = new AppUser($brother, 'user@cm.org');
        $appUser->setPassword($this->userPasswordHasher->hashPassword($appUser, 'password'));

        $this->entityManager->persist($appUser);
        $this->entityManager->flush();

        $this->appSecurityService->logIn($appUser);
        $this->sharedStorage->set('app_user', $appUser);
    }
}
