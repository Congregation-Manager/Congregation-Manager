<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use DateTimeImmutable;

class AppUserInvitation
{
    protected DateTimeImmutable $createdAt;

    public function __construct(
        protected BrotherInterface $brother,
        protected string $email,
        protected string $token
    ) {
        $this->createdAt = new DateTimeImmutable('now');
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
