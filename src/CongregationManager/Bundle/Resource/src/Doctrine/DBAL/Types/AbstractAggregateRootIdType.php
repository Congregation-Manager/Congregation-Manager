<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Resource\Doctrine\DBAL\Types;

use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;

abstract class AbstractAggregateRootIdType extends Type
{
    public function convertToPHPValue($value, AbstractPlatform $platform): ?AggregateRootId
    {
        if ($value === null) {
            return null;
        }

        return $this->getCurrentTypeConvertToPHPValueImplementation($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }
        // @TODO Is this the right way? See features/account/app_accept_invite.feature:12 scenario
        if (is_string($value)) {
            return $value;
        }
        if ($value instanceof AggregateRootId) {
            return $value->convertToDatabaseValue();
        }

        throw new InvalidArgumentException(sprintf(
            'Expected value to be an instance of "%s", got "%s".',
            AggregateRootId::class,
            get_debug_type($value)
        ));
    }

    abstract protected function getCurrentTypeConvertToPHPValueImplementation(mixed $value): AggregateRootId;
}
