<?php

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface LoginPageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function specifyPassword(string $password): void;

    public function signIn(): void;

    public function getActiveLocale(): string;

    /** @return string[] */
    public function getAvailableLocales(): array;

    public function switchLocale(string $locale): void;
}
