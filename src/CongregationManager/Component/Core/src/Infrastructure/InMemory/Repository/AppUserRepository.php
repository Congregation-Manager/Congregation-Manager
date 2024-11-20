<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Infrastructure\InMemory\Repository;

use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Component\Core\Domain\Repository\AppUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;

/**
 * @implements AppUserRepositoryInterface<AppUserInterface>
 */
final class AppUserRepository implements AppUserRepositoryInterface
{
    /**
     * @var AppUserInterface[]
     */
    public array $appUsers = [];

    #[\Override]
    public function add(UserInterface $user): void
    {
        if (!$user instanceof AppUserInterface) {
            throw new \InvalidArgumentException('User must be an instance of AppUserInterface');
        }
        if (in_array($user, $this->appUsers, true)) {
            return;
        }

        $this->appUsers[] = $user;
    }
}
