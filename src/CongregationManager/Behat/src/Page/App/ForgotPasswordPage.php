<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ForgotPasswordPage extends SymfonyPage implements ForgotPasswordPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'congregation_manager_app_forgot_password_request';
    }

    #[\Override]
    public function specifyEmail(string $email): void
    {
        $this->getElement('email')
            ->setValue($email)
        ;
    }

    #[\Override]
    public function submit(): void
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
            'email' => 'input[type=email]',
            'submit_button' => 'button[type=submit]',
        ]);
    }
}
