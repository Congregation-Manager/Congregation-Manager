<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource;

use CongregationManager\Contract\Resource\Id;
use InvalidArgumentException;
use Symfony\Component\Uid\UuidV4 as SymfonyUuidV4;

final class UuidV4 extends SymfonyUuidV4 implements Id
{
    public function __toString(): string
    {
        return $this->toRfc4122();
    }

    public static function generateFromString(string $uuid): self
    {
        return parent::fromString($uuid);
    }

    public function equals(mixed $otherId): bool
    {
        if (! $otherId instanceof self) {
            return false;
        }

        return $this->uid === $otherId->uid;
    }

    public static function convertToPHPValue(mixed $databaseValue): Id
    {
        if (! is_string($databaseValue)) {
            throw new InvalidArgumentException('Invalid database value');
        }

        return new self($databaseValue);
    }

    public function convertToDatabaseValue(): string
    {
        return $this->toHex();
    }
}
