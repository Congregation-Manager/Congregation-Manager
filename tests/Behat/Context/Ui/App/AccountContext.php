<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Ui\App;

use Behat\Behat\Context\Context;
use CongregationManager\Tests\Behat\Page\App\ChangePasswordPageInterface;
use CongregationManager\Tests\Behat\Page\App\CheckEmailPageInterface;
use CongregationManager\Tests\Behat\Page\App\CompleteAccountPageInterface;
use CongregationManager\Tests\Behat\Page\App\DashboardPageInterface;
use CongregationManager\Tests\Behat\Page\App\ForgotPasswordPageInterface;
use CongregationManager\Tests\Behat\Page\App\LoginPageInterface;
use CongregationManager\Tests\Behat\Page\App\ProfileUpdatePageInterface;
use CongregationManager\Tests\Behat\Page\App\ResetPasswordPageInterface;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use Webmozart\Assert\Assert;

final class AccountContext implements Context
{
    public function __construct(
        private LoginPageInterface $loginPage,
        private DashboardPageInterface $dashboardPage,
        private ForgotPasswordPageInterface $forgotPasswordPage,
        private CheckEmailPageInterface $checkEmailPage,
        private ResetPasswordPageInterface $resetPasswordPage,
        private ProfileUpdatePageInterface $profileUpdatePage,
        private SharedStorageInterface $sharedStorage,
        private ChangePasswordPageInterface $changePasswordPage,
        private CompleteAccountPageInterface $completeAccountPage
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
        $this->resetPasswordPage->tryToOpen([
            'token' => $this->sharedStorage->get('forgot_password_token'),
        ]);
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
     * @When I log out
     */
    public function iLogOut(): void
    {
        $this->dashboardPage->open();
        $this->dashboardPage->signOut();
    }

    /**
     * @When I want to change my email
     * @When I want to update my profile
     */
    public function iWantToUpdateMyProfile(): void
    {
        $this->profileUpdatePage->open();
    }

    /**
     * @Given I change my first name with :firstName
     */
    public function iChangeMyFirstNameWith(string $firstName): void
    {
        $this->profileUpdatePage->specifyFirstName($firstName);
    }

    /**
     * @Given I change my middle name with :middleName
     */
    public function iChangeMyMiddleNameWith(string $middleName): void
    {
        $this->profileUpdatePage->specifyMiddleName($middleName);
    }

    /**
     * @Given I change my last name with :lastName
     */
    public function iChangeMyLastNameWith(string $lastName): void
    {
        $this->profileUpdatePage->specifyLastName($lastName);
    }

    /**
     * @Given I update the profile
     */
    public function iUpdateTheProfile(): void
    {
        $this->profileUpdatePage->update();
    }

    /**
     * @Then I should be logged in as :fullName
     */
    public function iShouldBeLoggedInAs(string $fullName): void
    {
        Assert::eq($this->dashboardPage->getLoggedInBrotherFullName(), $fullName);
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
     * @Given I update the password
     */
    public function iUpdateThePassword(): void
    {
        $this->changePasswordPage->update();
    }

    /**
     * @When I log in as :email
     * @When I log in as :email with password :password
     */
    public function iLogInAs(string $email, string $password = 'password'): void
    {
        $this->loginPage->open();
        $this->loginPage->specifyEmail($email);
        $this->loginPage->specifyPassword($password);
        $this->loginPage->signIn();
    }

    /**
     * @When I follow link on my email to complete my account
     */
    public function iFollowLinkOnMyEmailToCompleteMyAccount(): void
    {
        $this->completeAccountPage->tryToOpen([
            'token' => $this->sharedStorage->get('invitation_app_token'),
        ]);
        $this->completeAccountPage->verify();
    }

    /**
     * @Given I specify my password as :password
     */
    public function iSpecifyMyPasswordAs(string $password): void
    {
        $this->completeAccountPage->specifyPassword($password);
    }

    /**
     * @Given I confirm my password as :password
     */
    public function iConfirmMyPasswordAs(string $password): void
    {
        $this->completeAccountPage->confirmPassword($password);
    }

    /**
     * @Given I complete my account
     */
    public function iCompleteMyAccount(): void
    {
        $this->completeAccountPage->complete();
    }
}
