<?php

declare(strict_types=1);

namespace App\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ChangePasswordPage extends SymfonyPage implements ChangePasswordPageInterface
{
    protected static $additionalParameters = ['_locale' => 'en'];

    public function getRouteName(): string
    {
        return 'app_change_password';
    }

    public function specifyActualPassword(string $password): void
    {
        $this->getElement('old_password')->setValue($password);
    }

    public function specifyPassword(string $password): void
    {
        $this->getElement('password')->setValue($password);
    }

    public function confirmPassword(string $password): void
    {
        $this->getElement('confirm_password')->setValue($password);
    }

    public function update(): void
    {
        $this->getElement('submit_button')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'old_password' => '#change_password_form_oldPassword',
            'password' => '#change_password_form_plainPassword_first',
            'confirm_password' => '#change_password_form_plainPassword_second',
            'submit_button' => 'button[type=submit]'
        ]);
    }
}
