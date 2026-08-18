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

    #[\Override]
    public function getRouteName(): string
    {
        return 'app_dashboard';
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

    #[\Override]
    public function getLoggedInBrotherFullName(): string
    {
        return (string) $this->getElement('logged_in_brother')
            ->getAttribute('data-test-logged-in-brother-full-name')
        ;
    }

    #[\Override]
    public function getActiveLocale(): string
    {
        return $this->getElement('active_locale')
            ->getText()
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
            'logged_in_brother' => '[data-test-logged-in-brother-full-name]',
            'logout_button' => '[data-test-logout-button]',
            'active_locale' => '[data-test-active-locale]',
        ]);

        return $elements;
    }
}
