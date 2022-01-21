<?php

namespace App\Domain\User\Model;

interface UserInterface
{
    public function getId(): ?int;

    public function setId(?int $id): void;

    public function getEmail(): string;

    public function setEmail(string $email): void;

    public function getPassword(): ?string;

    public function setPassword(?string $password): void;
}
