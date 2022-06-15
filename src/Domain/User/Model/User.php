<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Common\Model\AggregateRoot;

abstract class User extends AggregateRoot implements UserInterface
{
    public function __construct(
        protected string $email,
        protected ?string $password = null,
        protected ?string $localeCode = null
    ) {
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getLocaleCode(): ?string
    {
        return $this->localeCode;
    }

    public function setLocaleCode(?string $localeCode): void
    {
        $this->localeCode = $localeCode;
    }
}
