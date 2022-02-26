<?php

namespace CongregationManager\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ResetPasswordPage extends SymfonyPage implements ResetPasswordPageInterface
{
    protected static $additionalParameters = ['_locale' => 'en'];

    public function getRouteName(): string
    {
        return 'app_reset_password';
    }

    public function specifyPassword(string $password): void
    {
        $this->getElement('password')->setValue($password);
    }

    public function confirmPassword(string $password): void
    {
        $this->getElement('confirm_password')->setValue($password);
    }

    public function submit(): void
    {
        $this->getElement('submit_button')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'password' => '#change_password_form_plainPassword_first',
            'confirm_password' => '#change_password_form_plainPassword_second',
            'submit_button' => 'button[type=submit]'
        ]);
    }
}
