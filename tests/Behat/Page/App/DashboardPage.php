<?php

namespace App\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class DashboardPage extends SymfonyPage implements DashboardPageInterface
{
    protected static $additionalParameters = ['_locale' => 'en'];

    public function getRouteName(): string
    {
        return 'app_dashboard';
    }

    public function hasLogoutButton(): bool
    {
        return $this->hasElement('logout_button');
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'logout_button' => 'a:contains("Sign out")'
        ]);
    }
}
