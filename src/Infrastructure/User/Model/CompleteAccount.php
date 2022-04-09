<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

final class CompleteAccount
{
    public function __construct(
        private BrotherInterface $brother,
        private string $email,
        private string $plainPassword
    ) {
    }

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
}
