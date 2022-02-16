<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\App;

use Behat\Mink\Element\NodeElement;
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

    public function getAvailableLocales(): array
    {
        return array_map(
            static function (NodeElement $element) {
                return $element->getText();
            },
            $this->getElement('locale_selector')->findAll('css', '[data-test-available-locale]')
        );
    }

    public function switchLocale(string $locale): void
    {
        $this->getElement('locale_selector')->clickLink($locale);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'active_locale' => '[data-test-active-locale]',
            'locale_selector' => '[data-test-locale-selector]',
        ]);
    }
}
