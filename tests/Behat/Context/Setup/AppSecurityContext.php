<?php

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Infrastructure\User\Model\AppUser;
use CongregationManager\Tests\Behat\Services\SecurityServiceInterface;
use Doctrine\Persistence\ObjectRepository;
use Webmozart\Assert\Assert;

final class AppSecurityContext implements Context
{
    public function __construct(
        private ObjectRepository $appUserRepository,
        private SecurityServiceInterface $securityService
    ) {
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs(string $email): void
    {
        $user = $this->appUserRepository->findOneBy(['email' => $email]);
        Assert::isInstanceOf($user, AppUser::class);

        $this->securityService->logIn($user);
    }
}
