<?php

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Infrastructure\User\Model\AdminUser;
use CongregationManager\Tests\Behat\Services\SecurityServiceInterface;
use Doctrine\Persistence\ObjectRepository;
use Webmozart\Assert\Assert;

final class AdminSecurityContext implements Context
{
    public function __construct(
        private ObjectRepository $adminUserRepository,
        private SecurityServiceInterface $securityService
    ) {
    }

    /**
     * @Given I am logged in as :email
     */
    public function iAmLoggedInAs(string $email): void
    {
        $user = $this->adminUserRepository->findOneBy(['email' => $email]);
        Assert::isInstanceOf($user, AdminUser::class);

        $this->securityService->logIn($user);
    }
}
