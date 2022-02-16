<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class HomePage extends SymfonyPage implements HomePageInterface
{
    protected static $additionalParameters = ['_locale' => 'en'];

    public function getRouteName(): string
    {
        return 'app_homepage';
    }

    public function getActiveLocale(): string
    {
        return $this->getElement('active_locale')->getText();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'active_locale' => '[data-test-active-locale]',
        ]);
    }
}
