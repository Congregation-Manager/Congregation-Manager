<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

interface UIUserInterface extends UserInterface
{
    public function getPassword(): ?string;

    public function setPassword(?string $password): void;
}
