<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Contract\Resource\AggregateRootInterface;

interface UserInterface extends AggregateRootInterface
{
    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function setLocaleCode(?string $localeCode): void;

    public function getLocaleCode(): ?string;
}
