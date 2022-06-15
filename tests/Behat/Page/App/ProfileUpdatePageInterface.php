<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ProfileUpdatePageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function update(): void;

    public function specifyFirstName(string $firstName): void;

    public function specifyMiddleName(string $middleName): void;

    public function specifyLastName(string $lastName): void;
}
