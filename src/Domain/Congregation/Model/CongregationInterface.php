<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Congregation\Model;

interface CongregationInterface
{
    public function getId(): ?int;

    public function getName(): string;

    public function setName(string $name): void;
}
