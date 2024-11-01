<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Page\App;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface DashboardPageInterface extends SymfonyPageInterface
{
    public function hasLogoutButton(): bool;

    public function signOut(): void;

    public function getLoggedInBrotherFullName(): string;

    public function getActiveLocale(): string;
}
