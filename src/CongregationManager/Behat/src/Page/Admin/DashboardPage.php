<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class DashboardPage extends SymfonyPage implements DashboardPageInterface
{
    /**
     * @var array<string, string>
     */
    protected static $additionalParameters = [
        '_locale' => 'en',
    ];

    #[\Override]
    public function getRouteName(): string
    {
        return 'admin_dashboard';
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
        return array_merge(parent::getDefinedElements(), [
            'logout_button' => '[data-test-logout-button]',
        ]);
    }
}
