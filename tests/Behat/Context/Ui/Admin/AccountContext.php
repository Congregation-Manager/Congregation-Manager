<?php

namespace App\Tests\Behat\Context\Ui\Admin;

use App\Tests\Behat\Page\Admin\ChangePasswordPageInterface;
use App\Tests\Behat\Page\Admin\CheckEmailPageInterface;
use App\Tests\Behat\Page\Admin\DashboardPageInterface;
use App\Tests\Behat\Page\Admin\ForgotPasswordPageInterface;
use App\Tests\Behat\Page\Admin\LoginPageInterface;
use App\Tests\Behat\Page\Admin\ProfileUpdatePageInterface;
use App\Tests\Behat\Page\Admin\ResetPasswordPageInterface;
use App\Tests\Behat\Services\SharedStorageInterface;
use Behat\Behat\Context\Context;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    public function __construct(
        private LoginPageInterface $loginPage,
        private DashboardPageInterface $dashboardPage,
        private ForgotPasswordPageInterface $forgotPasswordPage,
        private CheckEmailPageInterface $checkEmailPage,
        private ResetPasswordPageInterface $resetPasswordPage,
        private SharedStorageInterface $sharedStorage,
        private ProfileUpdatePageInterface $profileUpdatePage,
        private ChangePasswordPageInterface $changePasswordPage
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

    /**
     * @When /^I try to open dashboard$/
     */
    public function iTryToOpenDashboard(): void
    {
        $this->dashboardPage->tryToOpen();
    }

    /**
     * @Then /^I should be redirected to the login page$/
     */
    public function iShouldBeRedirectedToTheLoginPage(): void
    {
        $this->loginPage->verify();
    }

    /**
     * @When /^I want to reset password$/
     */
    public function iWantToResetPassword(): void
    {
        $this->forgotPasswordPage->open();
    }

    /**
     * @Given /^I specify email as "([^"]*)"$/
     */
    public function iSpecifyEmailAs(string $email): void
    {
        $this->forgotPasswordPage->specifyEmail($email);
    }

    /**
     * @Given /^I submit the forgot password$/
     */
    public function iSubmitTheForgotPassword(): void
    {
        $this->forgotPasswordPage->submit();
    }

    /**
     * @Then /^I should be invited to check my email$/
     */
    public function iShouldBeInvitedToCheckMyEmail(): void
    {
        $this->checkEmailPage->verify();
    }

    /**
     * @When I follow link on my email to reset my password
     */
    public function iFollowLinkOnMyEmailToResetMyPassword(): void
    {
        $this->resetPasswordPage->tryToOpen(['token' => $this->sharedStorage->get('forgot_password_token')]);
        $this->resetPasswordPage->verify();
    }

    /**
     * @Given I specify my new password as :password
     */
    public function iSpecifyMyNewPasswordAs(string $password): void
    {
        $this->resetPasswordPage->specifyPassword($password);
    }

    /**
     * @Given I confirm my new password as :password
     */
    public function iConfirmMyNewPasswordAs(string $password): void
    {
        $this->resetPasswordPage->confirmPassword($password);
    }

    /**
     * @Given I reset it
     */
    public function iResetIt(): void
    {
        $this->resetPasswordPage->submit();
    }

    /**
     * @Given I should be able to log in as :email with :password password
     */
    public function iShouldBeAbleToLogInAsWithPassword(string $email, string $password): void
    {
        $this->loginPage->open();
        $this->loginPage->specifyEmail($email);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->signIn();

        $this->iShouldBeLoggedIn();
    }

    /**
     * @When I change my email with :email
     */
    public function iChangeMyEmailWith(string $email): void
    {
        $this->profileUpdatePage->specifyEmail($email);
        $this->profileUpdatePage->update();
    }

    /**
     * @WHen I log out
     */
    public function iLogOut(): void
    {
        $this->dashboardPage->signOut();
    }

    /**
     * @When I want to change my email
     */
    public function iWantToChangeMyEmail(): void
    {
        $this->profileUpdatePage->open();
    }

    /**
     * @When I want to change my password
     */
    public function iWantToChangeMyPassword(): void
    {
        $this->changePasswordPage->open();
    }

    /**
     * @Given I change my password with :password
     */
    public function iChangeMyPasswordWith(string $password): void
    {
        $this->changePasswordPage->specifyPassword($password);
    }

    /**
     * @Given I confirm my password with :password
     */
    public function iConfirmMyPasswordWith(string $password): void
    {
        $this->changePasswordPage->confirmPassword($password);
    }

    /**
     * @Given I specify my actual password with :password
     */
    public function iSpecifyMyActualPasswordWith(string $password): void
    {
        $this->changePasswordPage->specifyActualPassword($password);
    }

    /**
     * @Given I update it
     */
    public function iUpdateIt(): void
    {
        $this->changePasswordPage->update();
    }
}
