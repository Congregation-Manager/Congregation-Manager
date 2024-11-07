<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class InviteAppUserPage extends SymfonyPage implements InviteAppUserPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_admin_invite_app_user';
    }

    #[\Override]
    public function specifyEmail(string $email): void
    {
        $this->getElement('email')
            ->setValue($email)
        ;
    }

    #[\Override]
    public function sendInvite(): void
    {
        $this->getElement('submit')
            ->click()
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '[data-test-email]',
            'submit' => '[data-test-submit]',
        ]);
    }
}
