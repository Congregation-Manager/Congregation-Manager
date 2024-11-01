<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPage;

final class ProfileUpdatePage extends SymfonyPage implements ProfileUpdatePageInterface
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
        return 'admin_profile_update';
    }

    #[\Override]
    public function specifyEmail(string $email): void
    {
        $this->getElement('email')
            ->setValue($email)
        ;
    }

    #[\Override]
    public function update(): void
    {
        $this->getElement('save_button')
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
            'save_button' => 'button[type=submit]',
        ]);
    }
}
