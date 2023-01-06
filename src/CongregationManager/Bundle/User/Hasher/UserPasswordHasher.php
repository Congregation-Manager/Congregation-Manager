<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Hasher;

use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as SymfonyUserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Webmozart\Assert\Assert;

final class UserPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(
        private SymfonyUserPasswordHasherInterface $symfonyUserPasswordHasher
    ) {
    }

    public function hashPasswordForUser(string $plainPassword, UserInterface $user): string
    {
        Assert::isInstanceOf($user, PasswordAuthenticatedUserInterface::class);

        return $this->symfonyUserPasswordHasher->hashPassword($user, $plainPassword);
    }
}
