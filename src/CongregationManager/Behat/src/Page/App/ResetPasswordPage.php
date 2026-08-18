<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ResetPasswordPage extends SymfonyPage implements ResetPasswordPageInterface
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
        return 'congregation_manager_app_reset_password';
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
            'password' => '#change_password_form_plainPassword_first',
            'confirm_password' => '#change_password_form_plainPassword_second',
            'submit_button' => 'button[type=submit]',
        ]);

        return $elements;
    }
}
