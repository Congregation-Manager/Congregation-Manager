<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use DateTimeImmutable;

interface AggregateRootInterface extends \Stringable
{
    public function getId(): ?int;

    public function setId(?int $id): void;

    public function getCreatedAt(): ?DateTimeImmutable;

    public function getUpdatedAt(): ?DateTimeImmutable;
}
