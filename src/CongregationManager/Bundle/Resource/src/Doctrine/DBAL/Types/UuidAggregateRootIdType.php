<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Doctrine\DBAL\Types;

use CongregationManager\Bundle\Resource\Uid\UuidAggregateRootId;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\DBAL\Platforms\AbstractPlatform;

final class UuidAggregateRootIdType extends AbstractAggregateRootIdType
{
    public const string NAME = 'uuid_aggregate_root_id';

    #[\Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[\Override]
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    #[\Override]
    protected function getCurrentTypeConvertToPHPValueImplementation(mixed $value): AggregateRootId
    {
        return UuidAggregateRootId::convertToPHPValue($value);
    }
}
