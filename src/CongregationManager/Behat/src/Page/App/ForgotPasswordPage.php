<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ForgotPasswordPage extends SymfonyPage implements ForgotPasswordPageInterface
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
        /** @var array<string, array<string>|string> $elements */
        $elements = array_merge(parent::getDefinedElements(), [
            'email' => 'input[type=email]',
            'submit_button' => 'button[type=submit]',
        ]);

        return $elements;
    }
}
