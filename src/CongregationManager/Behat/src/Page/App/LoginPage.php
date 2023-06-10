<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

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
        return 'app_login';
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

    /**
     * @return array<string, string|string[]>
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'username' => 'input[name=_username]',
            'password' => 'input[name=_password]',
            'signin_button' => 'button[type=submit]',
        ]);
    }
}
