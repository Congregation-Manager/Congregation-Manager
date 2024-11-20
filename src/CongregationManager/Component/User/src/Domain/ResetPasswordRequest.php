<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;
use DateTimeInterface;

class ResetPasswordRequest extends AggregateRoot implements ResetPasswordRequestInterface
{
    public function __construct(
        protected DateTimeInterface $expiresAt,
        protected string $hashedToken,
        protected UIUserInterface $user,
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, (string) $this->getUiUser());
    }

    #[\Override]
    public function getUiUser(): UIUserInterface
    {
        return $this->user;
    }

    #[\Override]
    public function setUser(UIUserInterface $user): void
    {
        $this->user = $user;
    }

    #[\Override]
    public function getExpiresAt(): DateTimeInterface
    {
        return $this->expiresAt;
    }

    #[\Override]
    public function setExpiresAt(DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    #[\Override]
    public function getHashedToken(): string
    {
        return $this->hashedToken;
    }

    #[\Override]
    public function setHashedToken(string $hashedToken): void
    {
        $this->hashedToken = $hashedToken;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt->getTimestamp() <= time();
    }
}
