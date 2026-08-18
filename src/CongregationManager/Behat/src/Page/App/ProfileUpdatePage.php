<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

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
        return 'app_profile_update';
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

    #[\Override]
    public function specifyFirstName(string $firstName): void
    {
        $this->getElement('first_name')
            ->setValue($firstName)
        ;
    }

    #[\Override]
    public function specifyMiddleName(string $middleName): void
    {
        $this->getElement('middle_name')
            ->setValue($middleName)
        ;
    }

    #[\Override]
    public function specifyLastName(string $lastName): void
    {
        $this->getElement('last_name')
            ->setValue($lastName)
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
            'first_name' => '[data-test-brother-first-name]',
            'middle_name' => '[data-test-brother-middle-name]',
            'last_name' => '[data-test-brother-last-name]',
            'save_button' => 'button[type=submit]',
        ]);

        return $elements;
    }
}
