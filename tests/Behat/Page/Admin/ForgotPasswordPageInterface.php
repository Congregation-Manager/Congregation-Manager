<?php

namespace App\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ForgotPasswordPageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function submit(): void;
}
