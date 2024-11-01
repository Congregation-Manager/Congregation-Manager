<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class BrotherShowPage extends SymfonyPage implements BrotherShowPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'admin_brother_show';
    }

    #[\Override]
    public function hasUser(): bool
    {
        try {
            $this->getElement('invite_user');
        } catch (ElementNotFoundException) {
            return true;
        }

        return false;
    }

    #[\Override]
    public function inviteUser(): void
    {
        $this->getElement('invite_user')
            ->click()
        ;
    }

    #[\Override]
    public function hasUserInvitation(): bool
    {
        return $this->hasElement('user_invitation');
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'invite_user' => '[data-test-invite-user-button]',
            'user_invitation' => '[data-test-user-invitation]',
        ]);
    }
}
