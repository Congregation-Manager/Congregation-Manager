<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Hasher;

use CongregationManager\Component\User\Domain\UIUserInterface;

interface UserPasswordHasherInterface
{
    public function hashPasswordForUser(string $plainPassword, UIUserInterface $user): string;
}
