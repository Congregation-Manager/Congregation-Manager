<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

interface UserInterface
{
    public function getId(): ?int;

    public function setId(?int $id): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): ?string;

    public function setPassword(?string $password): void;

    public function setLocaleCode(?string $localeCode): void;

    public function getLocaleCode(): ?string;
}
