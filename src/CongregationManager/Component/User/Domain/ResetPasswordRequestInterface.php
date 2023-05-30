<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRootInterface;
use DateTimeInterface;

interface ResetPasswordRequestInterface extends AggregateRootInterface
{
    public function getAppUser(): ?AppUserInterface;

    public function setAppUser(?AppUserInterface $appUser): void;

    public function getAdminUser(): ?AdminUserInterface;

    public function setAdminUser(?AdminUserInterface $adminUser): void;

    public function getExpiresAt(): DateTimeInterface;

    public function setExpiresAt(DateTimeInterface $expiresAt): void;

    public function getHashedToken(): string;

    public function setHashedToken(string $hashedToken): void;
}
