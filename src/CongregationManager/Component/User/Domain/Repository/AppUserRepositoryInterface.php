<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Repository;

use CongregationManager\Component\User\Domain\AppUserInterface;

interface AppUserRepositoryInterface
{
    public function add(AppUserInterface $appUser): void;
}
