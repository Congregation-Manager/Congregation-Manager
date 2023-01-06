<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Doctrine\DBAL\Types;

use CongregationManager\Contract\Resource\IntegerAggregateRootId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

final class IntegerAggregateRootIdType extends Type
{
    public const NAME = 'integer_aggregate_root_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?IntegerAggregateRootId
    {
        return $value === null ? null : new IntegerAggregateRootId((int) $value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        if ($value instanceof IntegerAggregateRootId) {
            return (string) $value;
        }

        throw new InvalidArgumentException('Expected a IntegerAggregateRootId value');
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }
}
