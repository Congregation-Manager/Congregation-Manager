<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class HomePage extends SymfonyPage implements HomePageInterface
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
        return 'congregation_manager_app_homepage';
    }

    #[\Override]
    public function getActiveLocale(): string
    {
        return $this->getElement('active_locale')
            ->getText()
        ;
    }

    #[\Override]
    public function getAvailableLocales(): array
    {
        return array_map(
            static fn (NodeElement $element) => $element->getText(),
            $this->getElement('locale_selector')
                ->findAll('css', '[data-test-available-locale]')
        );
    }

    #[\Override]
    public function switchLocale(string $locale): void
    {
        $this->getElement('locale_selector')
            ->clickLink($locale)
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'active_locale' => '[data-test-active-locale]',
            'locale_selector' => '[data-test-locale-selector]',
        ]);
    }
}
