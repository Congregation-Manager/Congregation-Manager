<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface DashboardPageInterface extends SymfonyPageInterface
{
    public function hasLogoutButton(): bool;

    public function signOut(): void;
}
