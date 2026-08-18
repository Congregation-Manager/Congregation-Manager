<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class DashboardPage extends SymfonyPage implements DashboardPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_admin_dashboard';
    }

    #[\Override]
    public function hasLogoutButton(): bool
    {
        return $this->hasElement('logout_button');
    }

    #[\Override]
    public function signOut(): void
    {
        $this->getElement('logout_button')
            ->click()
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        /** @var array<string, array<string>|string> $elements */
        $elements = array_merge(parent::getDefinedElements(), [
            'logout_button' => '[data-test-logout-button]',
        ]);

        return $elements;
    }
}
