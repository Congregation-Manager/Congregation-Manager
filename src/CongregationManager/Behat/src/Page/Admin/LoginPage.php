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

    public function getRouteName(): string
    {
        return 'admin_login';
    }

    public function specifyEmail(string $email): void
    {
        $this->getElement('username')
            ->setValue($email)
        ;
    }

    public function specifyPassword(string $password): void
    {
        $this->getElement('password')
            ->setValue($password)
        ;
    }

    public function signIn(): void
    {
        $this->getElement('signin_button')
            ->click()
        ;
    }

    public function getActiveLocale(): string
    {
        return $this->getElement('active_locale')
            ->getText()
        ;
    }

    public function getAvailableLocales(): array
    {
        return array_map(
            static function (NodeElement $element) {
                return $element->getText();
            },
            $this->getElement('locale_selector')
                ->findAll('css', '[data-test-available-locale]')
        );
    }

    public function switchLocale(string $locale): void
    {
        $this->getElement('locale_selector')
            ->clickLink($locale)
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
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
