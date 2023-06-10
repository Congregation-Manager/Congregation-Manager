<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\EmailCheckerInterface;
use Webmozart\Assert\Assert;

final class EmailContext implements Context
{
    public function __construct(
        private EmailCheckerInterface $emailChecker
    ) {
    }

    /**
     * @Given /^an email with reset token should be sent to "([^"]*)"$/
     */
    public function anEmailWithResetTokenShouldBeSentTo(string $email): void
    {
        $this->assertEmailContainsMessageTo('To reset your password, please visit the following link', $email);
    }

    /**
     * @Given an email with user invite should be sent to :email
     */
    public function anEmailWithUserInviteShouldBeSentTo(string $email): void
    {
        $this->assertEmailContainsMessageTo(
            'Welcome to Congregation Manager, please visit the following link to complete your subscription',
            $email
        );
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
