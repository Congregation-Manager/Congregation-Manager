<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Uid;

use CongregationManager\Contract\Resource\AggregateRootId;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

final readonly class UuidAggregateRootId implements AggregateRootId
{
    public function __construct(
        private Uuid $uuid
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->uuid->toRfc4122();
    }

    #[\Override]
    public static function convertToPHPValue(mixed $databaseValue): self
    {
        if ($databaseValue instanceof Uuid) {
            return new self($databaseValue);
        }
        if (!is_string($databaseValue) || !Uuid::isValid($databaseValue)) {
            throw new InvalidArgumentException(sprintf(
                'Expected a valid UUID, got "%s".',
                get_debug_type($databaseValue)
            ));
        }

        return new self(Uuid::fromString($databaseValue));
    }

    #[\Override]
    public function equals(AggregateRootId $otherId): bool
    {
        if (!$otherId instanceof self) {
            return false;
        }

        return $this->uuid->equals($otherId->uuid);
    }

    #[\Override]
    public function convertToDatabaseValue(): string
    {
        return $this->uuid->toRfc4122();
    }
}
