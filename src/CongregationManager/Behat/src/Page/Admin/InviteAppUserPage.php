<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class InviteAppUserPage extends SymfonyPage implements InviteAppUserPageInterface
{
    public function getRouteName(): string
    {
        return 'admin_invite_app_user';
    }

    public function specifyEmail(string $email): void
    {
        $this->getElement('email')
            ->setValue($email)
        ;
    }

    public function sendInvite(): void
    {
        $this->getElement('submit')
            ->click()
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => '[data-test-email]',
            'submit' => '[data-test-submit]',
        ]);
    }
}
