<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

interface AggregateRootId extends Stringable
{
    public function __toString(): string;

    public static function convertToPHPValue(mixed $databaseValue): self;

    public function equals(self $otherId): bool;

    public function convertToDatabaseValue(): string;
}
