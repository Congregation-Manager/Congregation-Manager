<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use Stringable;

interface Id extends Stringable
{
    public function equals(self $otherId): bool;

    public static function convertToPHPValue(mixed $databaseValue): self;

    public function convertToDatabaseValue(): string;
}
