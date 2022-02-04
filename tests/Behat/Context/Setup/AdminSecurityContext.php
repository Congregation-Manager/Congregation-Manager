<?php

namespace App\Tests\Behat\Context\Setup;

use App\Infrastructure\User\Model\AdminUser;
use App\Tests\Behat\Services\SecurityServiceInterface;
use Behat\Behat\Context\Context;
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
