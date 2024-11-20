<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Repository;

use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Repository\UserRepositoryInterface;

/**
 * @template T of AppUserInterface
 * @extends UserRepositoryInterface<T>
 */
interface AppUserRepositoryInterface extends UserRepositoryInterface
{
}
