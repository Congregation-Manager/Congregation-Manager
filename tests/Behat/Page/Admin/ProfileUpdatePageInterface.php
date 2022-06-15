<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ProfileUpdatePageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function update(): void;
}
