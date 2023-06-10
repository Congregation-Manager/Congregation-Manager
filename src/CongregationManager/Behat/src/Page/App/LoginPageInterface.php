<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface LoginPageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function specifyPassword(string $password): void;

    public function signIn(): void;
}
