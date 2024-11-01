<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ChangePasswordPage extends SymfonyPage implements ChangePasswordPageInterface
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
        return 'app_change_password';
    }

    #[\Override]
    public function specifyActualPassword(string $password): void
    {
        $this->getElement('old_password')
            ->setValue($password)
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
    public function confirmPassword(string $password): void
    {
        $this->getElement('confirm_password')
            ->setValue($password)
        ;
    }

    #[\Override]
    public function update(): void
    {
        $this->getElement('submit_button')
            ->click()
        ;
    }

    /**
     * @return array<string, string|string[]>
     */
    #[\Override]
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'old_password' => '#change_password_form_oldPassword',
            'password' => '#change_password_form_plainPassword_first',
            'confirm_password' => '#change_password_form_plainPassword_second',
            'submit_button' => 'button[type=submit]',
        ]);
    }
}
