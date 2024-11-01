<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class CompleteAccountPage extends SymfonyPage implements CompleteAccountPageInterface
{
    #[\Override]
    public function getRouteName(): string
    {
        return 'app_complete_account';
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
    public function complete(): void
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
            'password' => '#complete_account_form_plainPassword_first',
            'confirm_password' => '#complete_account_form_plainPassword_second',
            'submit_button' => '[data-test-submit]',
        ]);
    }
}
