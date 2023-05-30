<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Repository;

use CongregationManager\Component\User\Domain\AppUser;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserRepositoryInterface;

final class AppUserRepository extends InMemoryRepository implements AppUserRepositoryInterface
{
    public function add(AppUserInterface $appUser): void
    {
        $this->objectCollection->add($appUser);
    }

    public function getClassName(): string
    {
        return AppUser::class;
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
