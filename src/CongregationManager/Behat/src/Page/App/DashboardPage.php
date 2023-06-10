<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class DashboardPage extends SymfonyPage implements DashboardPageInterface
{
    /**
     * @var array<string, string>
     */
    protected static $additionalParameters = [
        '_locale' => 'en',
    ];

    public function getRouteName(): string
    {
        return 'app_dashboard';
    }

    public function hasLogoutButton(): bool
    {
        return $this->hasElement('logout_button');
    }

    public function signOut(): void
    {
        $this->getElement('logout_button')
            ->click()
        ;
    }

    public function getLoggedInBrotherFullName(): string
    {
        return (string) $this->getElement('logged_in_brother')
            ->getAttribute('data-test-logged-in-brother-full-name')
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'logged_in_brother' => '[data-test-logged-in-brother-full-name]',
            'logout_button' => '[data-test-logout-button]',
        ]);
    }
}
