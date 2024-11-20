<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\EmailCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Webmozart\Assert\Assert;

final readonly class EmailContext implements Context
{
    public function __construct(
        private EmailCheckerInterface $emailChecker,
        private TranslatorInterface $translator,
    ) {
    }

    /**
     * @Given /^an email with reset token should be sent to "([^"]*)"$/
     */
    public function anEmailWithResetTokenShouldBeSentTo(string $email): void
    {
        $this->assertEmailContainsMessageTo(
            $this->translator->trans('congregation_manager_admin.email.reset_password.intro', [], 'admin', 'en'),
            $email
        );
    }

    /**
     * @Given an email with user invite should be sent to :email
     */
    public function anEmailWithUserInviteShouldBeSentTo(string $email): void
    {
        $this->assertEmailContainsMessageTo(
            $this->translator->trans('congregation_manager_admin.email.app_user_invitation.intro', [], 'admin', 'en'),
            $email
        );
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient));
    }
}
