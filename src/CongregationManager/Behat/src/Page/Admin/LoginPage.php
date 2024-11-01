<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use Behat\Mink\Element\NodeElement;
use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class LoginPage extends SymfonyPage implements LoginPageInterface
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
        return 'admin_login';
    }

    #[\Override]
    public function specifyEmail(string $email): void
    {
        $this->getElement('username')
            ->setValue($email)
        ;
    }

    #[\Override]
    public function specifyPassword(string $password): void
    {
        $this->getElement('password')
            ->setValue($password)
        ;
    }

    #[\Override]
    public function signIn(): void
    {
        $this->getElement('signin_button')
            ->click()
        ;
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
            'username' => 'input[name=_username]',
            'password' => 'input[name=_password]',
            'signin_button' => 'button[type=submit]',
            'active_locale' => '[data-test-active-locale]',
            'locale_selector' => '[data-test-locale-selector]',
        ]);
    }
}
