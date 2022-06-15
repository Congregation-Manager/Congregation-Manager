<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ResetPasswordPageInterface extends SymfonyPageInterface
{
    public function specifyPassword(string $password): void;

    public function confirmPassword(string $password): void;

    public function submit(): void;
}
