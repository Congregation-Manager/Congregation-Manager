<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Repository;

use CongregationManager\Component\User\Domain\UserInterface;

/**
 * @template T of UserInterface
 */
interface UserRepositoryInterface
{
    /**
     * @param T $user
     */
    public function add(UserInterface $user): void;
}
