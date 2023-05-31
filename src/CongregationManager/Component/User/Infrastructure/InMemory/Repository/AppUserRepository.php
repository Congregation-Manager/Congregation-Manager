<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Infrastructure\InMemory\Repository;

use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserRepositoryInterface;

final class AppUserRepository implements AppUserRepositoryInterface
{
    /**
     * @var AppUserInterface[]
     */
    public array $appUsers = [];

    public function add(AppUserInterface $appUser): void
    {
        if (in_array($appUser, $this->appUsers, true)) {
            return;
        }

        $this->appUsers[] = $appUser;
    }
}
