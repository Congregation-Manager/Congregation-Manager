<?php

namespace App\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ChangePasswordPageInterface extends SymfonyPageInterface
{
    public function specifyPassword(string $password): void;

    public function confirmPassword(string $password): void;

    public function update(): void;

    public function specifyActualPassword(string $password): void;
}
