<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Page\Admin;

use FriendsOfBehat\PageObjectExtension\Page\SymfonyPageInterface;

interface BrotherShowPageInterface extends SymfonyPageInterface
{
    public function hasUser(): bool;

    public function inviteUser(): void;

    public function hasUserInvitation(): bool;
}
