<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Hasher;

use CongregationManager\Component\User\Domain\UserInterface;

interface UserPasswordHasherInterface
{
    public function hashPasswordForUser(string $plainPassword, UserInterface $user): string;
}
