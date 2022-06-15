<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface HomePageInterface extends SymfonyPageInterface
{
    public function getActiveLocale(): string;

    /**
     * @return string[]
     */
    public function getAvailableLocales(): array;

    public function switchLocale(string $locale): void;
}
