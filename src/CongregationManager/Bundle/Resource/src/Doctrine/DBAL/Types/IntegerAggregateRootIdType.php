<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Doctrine\DBAL\Types;

use CongregationManager\Contract\Resource\AggregateRootId;
use CongregationManager\Contract\Resource\IntegerAggregateRootId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class IntegerAggregateRootIdType extends AbstractAggregateRootIdType
{
    public const NAME = 'integer_aggregate_root_id';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($column);
    }

    protected function getCurrentTypeConvertToPHPValueImplementation(mixed $value): AggregateRootId
    {
        return IntegerAggregateRootId::convertToPHPValue($value);
    }
}
