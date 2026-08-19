<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use DateTimeImmutable;

interface AggregateRootInterface extends \Stringable
{
    public function getId(): AggregateRootId;

    public function getCreatedAt(): ?DateTimeImmutable;

    public function getUpdatedAt(): ?DateTimeImmutable;
}
