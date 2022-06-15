<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

use DateTimeInterface;

interface ResetPasswordRequestInterface
{
    public function getId(): ?int;

    public function setId(?int $id): void;

    public function getAppUser(): ?AppUserInterface;

    public function setAppUser(?AppUserInterface $appUser): void;

    public function getAdminUser(): ?AdminUserInterface;

    public function setAdminUser(?AdminUserInterface $adminUser): void;

    public function getExpiresAt(): DateTimeInterface;

    public function setExpiresAt(DateTimeInterface $expiresAt): void;

    public function getHashedToken(): string;

    public function setHashedToken(string $hashedToken): void;
}
