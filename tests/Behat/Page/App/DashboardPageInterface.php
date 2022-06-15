<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface DashboardPageInterface extends SymfonyPageInterface
{
    public function hasLogoutButton(): bool;

    public function signOut(): void;

    public function getLoggedInBrotherFullName(): string;
}
