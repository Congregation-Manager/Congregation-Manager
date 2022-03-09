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

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'invite_user' => '[data-test-invite-user-button]'
        ]);
    }
}
