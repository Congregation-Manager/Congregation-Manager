<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRoot;

class User extends AggregateRoot implements UserInterface
{
    public function __construct(
        protected string $email,
        protected ?string $localeCode = null
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        return sprintf('%s[%s]', self::class, $this->getEmail());
    }

    #[\Override]
    public function getEmail(): string
    {
        return $this->email;
    }

    #[\Override]
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    #[\Override]
    public function getLocaleCode(): ?string
    {
        return $this->localeCode;
    }

    #[\Override]
    public function setLocaleCode(?string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }
}
