<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface ForgotPasswordPageInterface extends SymfonyPageInterface
{
    public function specifyEmail(string $email): void;

    public function submit(): void;
}
