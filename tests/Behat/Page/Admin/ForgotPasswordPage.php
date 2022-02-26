<?php

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ForgotPasswordPage extends SymfonyPage implements ForgotPasswordPageInterface
{
    protected static $additionalParameters = ['_locale' => 'en'];

    public function getRouteName(): string
    {
        return 'admin_forgot_password_request';
    }

    public function specifyEmail(string $email): void
    {
        $this->getElement('email')->setValue($email);
    }

    public function submit(): void
    {
        $this->getElement('submit_button')->click();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'email' => 'input[type=email]',
            'submit_button' => 'button[type=submit]'
        ]);
    }
}
