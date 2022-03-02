<?php

namespace CongregationManager\Domain\User\Repository;

use CongregationManager\Domain\User\Model\AppUserInterface;

interface AppUserRepositoryInterface
{
    public function add(AppUserInterface $appUser): void;
}
