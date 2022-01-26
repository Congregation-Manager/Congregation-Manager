<?php

namespace App\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ResetPasswordPageInterface extends SymfonyPageInterface
{
    public function specifyPassword(string $password): void;

    public function confirmPassword(string $password): void;

    public function submit(): void;
}
