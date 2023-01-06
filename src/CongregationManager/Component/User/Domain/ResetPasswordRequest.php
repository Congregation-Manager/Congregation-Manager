<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;
use DateTimeInterface;

class ResetPasswordRequest extends AggregateRoot implements ResetPasswordRequestInterface
{
    protected ?int $id = null;

    public function __construct(
        protected DateTimeInterface $expiresAt,
        protected string $hashedToken,
        protected ?AppUserInterface $appUser = null,
        protected ?AdminUserInterface $adminUser = null,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAppUser(): ?AppUserInterface
    {
        return $this->appUser;
    }

    public function setAppUser(?AppUserInterface $appUser): void
    {
        $this->appUser = $appUser;
    }

    public function getAdminUser(): ?AdminUserInterface
    {
        return $this->adminUser;
    }

    public function setAdminUser(?AdminUserInterface $adminUser): void
    {
        $this->adminUser = $adminUser;
    }

    public function getExpiresAt(): DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getHashedToken(): string
    {
        return $this->hashedToken;
    }

    public function setHashedToken(string $hashedToken): void
    {
        $this->hashedToken = $hashedToken;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt->getTimestamp() <= time();
    }
}
