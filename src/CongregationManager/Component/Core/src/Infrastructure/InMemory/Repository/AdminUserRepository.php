<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Infrastructure\InMemory\Repository;

use CongregationManager\Component\Core\Domain\AdminUser;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Component\Core\Domain\Repository\AdminUserRepositoryInterface;
use CongregationManager\Component\User\Domain\UserInterface;

/**
 * @template T of AdminUser
 * @implements AdminUserRepositoryInterface<T>
 */
final class AdminUserRepository implements AdminUserRepositoryInterface
{
    /**
     * @var AdminUserInterface[]
     */
    public array $adminUsers = [];

    #[\Override]
    public function add(UserInterface $user): void
    {
        if (!$user instanceof AdminUserInterface) {
            throw new \InvalidArgumentException('User must be an instance of AdminUserInterface');
        }
        if (in_array($user, $this->adminUsers, true)) {
            return;
        }

        $this->adminUsers[] = $user;
    }
}
