<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\Admin;

use Behat\Mink\Exception\ElementNotFoundException;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class BrotherShowPage extends SymfonyPage implements BrotherShowPageInterface
{
    public function getRouteName(): string
    {
        return 'admin_brother_show';
    }

    public function hasUser(): bool
    {
        try {
            $this->getElement('invite_user');
        } catch (ElementNotFoundException $e) {
            return true;
        }

        return false;
    }

    public function inviteUser(): void
    {
        $this->getElement('invite_user')
            ->click()
        ;
    }

    public function hasUserInvitation(): bool
    {
        return $this->hasElement('user_invitation');
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'invite_user' => '[data-test-invite-user-button]',
            'user_invitation' => '[data-test-user-invitation]',
        ]);
    }
}
