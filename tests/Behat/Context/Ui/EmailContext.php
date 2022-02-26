<?php

namespace CongregationManager\Tests\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use CongregationManager\Tests\Behat\Services\EmailCheckerInterface;
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
        $this->assertEmailContainsMessageTo(
            'To reset your password, please visit the following link',
            $email
        );
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
