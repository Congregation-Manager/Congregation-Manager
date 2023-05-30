<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use InvalidArgumentException;

final class IntegerAggregateRootId implements AggregateRootId
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public static function convertToPHPValue(mixed $databaseValue): self
    {
        if (! is_string($databaseValue) && ! is_numeric($databaseValue)) {
            throw new InvalidArgumentException(sprintf(
                'Expected value to be an convertible to int, got "%s".',
                get_debug_type($databaseValue)
            ));
        }

        return new self((int) $databaseValue);
    }

    public function equals(AggregateRootId $otherId): bool
    {
        if (! $otherId instanceof self) {
            return false;
        }

        return $this->id === $otherId->id;
    }

    public function convertToDatabaseValue(): string
    {
        return (string) $this;
    }
}
