<?php

namespace App\Tests\Behat\Context\Ui\Admin;

use App\Tests\Behat\Page\Admin\DashboardPageInterface;
use App\Tests\Behat\Page\Admin\LoginPageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    public function __construct(
        private LoginPageInterface $loginPage,
        private DashboardPageInterface $dashboardPage
    ) {
    }

    /**
     * @When I want to log in
     */
    public function iWantToLogIn(): void
    {
        $this->loginPage->open();
    }

    /**
     * @When I specify the email as :email
     */
    public function iSpecifyTheEmailAs(string $email): void
    {
        $this->loginPage->specifyEmail($email);
    }

    /**
     * @When I specify the password as :password
     */
    public function iSpecifyThePasswordAs(string $password): void
    {
        $this->loginPage->specifyPassword($password);
    }

    /**
     * @When I log in
     */
    public function iLogIn(): void
    {
        $this->loginPage->signIn();
    }

    /**
     * @Then I should be logged in
     */
    public function iShouldBeLoggedIn(): void
    {
        $this->dashboardPage->verify();
        Assert::true($this->dashboardPage->hasLogoutButton());
    }
}
