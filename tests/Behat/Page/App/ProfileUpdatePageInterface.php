<?php

namespace App\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ProfileUpdatePageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function update(): void;
}
