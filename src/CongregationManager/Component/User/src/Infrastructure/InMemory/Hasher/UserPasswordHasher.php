<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Infrastructure\InMemory\Hasher;

use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\UIUserInterface;

final class UserPasswordHasher implements UserPasswordHasherInterface
{
    #[\Override]
    public function hashPasswordForUser(string $plainPassword, UIUserInterface $user): string
    {
        return hash('sha256', $plainPassword);
    }
}
