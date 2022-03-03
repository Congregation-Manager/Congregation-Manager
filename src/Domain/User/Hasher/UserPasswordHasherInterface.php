<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Hasher;

use CongregationManager\Domain\User\Model\UserInterface;

interface UserPasswordHasherInterface
{
    public function hashPasswordForUser(string $plainPassword, UserInterface $user): string;
}
