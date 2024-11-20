<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Repository;

use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Component\User\Domain\Repository\UserRepositoryInterface;

/**
 * @template T of AdminUserInterface
 * @extends UserRepositoryInterface<T>
 */
interface AdminUserRepositoryInterface extends UserRepositoryInterface
{
}
