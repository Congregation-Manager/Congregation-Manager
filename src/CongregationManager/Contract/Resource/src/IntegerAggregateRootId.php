<?php

declare(strict_types=1);

namespace CongregationManager\Contract\Resource;

use InvalidArgumentException;

final readonly class IntegerAggregateRootId implements AggregateRootId
{
    public function __construct(
        private int $id
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        return (string) $this->id;
    }

    #[\Override]
    public static function convertToPHPValue(mixed $databaseValue): self
    {
        if (!is_string($databaseValue) && !is_numeric($databaseValue)) {
            throw new InvalidArgumentException(sprintf(
                'Expected value to be an convertible to int, got "%s".',
                get_debug_type($databaseValue)
            ));
        }

        return new self((int) $databaseValue);
    }

    #[\Override]
    public function equals(AggregateRootId $otherId): bool
    {
        if (!$otherId instanceof self) {
            return false;
        }

        return $this->id === $otherId->id;
    }

    #[\Override]
    public function convertToDatabaseValue(): string
    {
        return (string) $this;
    }
}
