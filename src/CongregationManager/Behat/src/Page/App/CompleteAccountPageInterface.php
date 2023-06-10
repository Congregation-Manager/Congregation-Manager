<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface CompleteAccountPageInterface extends SymfonyPageInterface
{
    public function specifyPassword(string $password): void;

    public function confirmPassword(string $password): void;

    public function complete(): void;
}
