<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Validator;

use Symfony\Component\Validator\Constraint;

/** @psalm-suppress PropertyNotSetInConstructor */
final class ValidTerritoryAssignments extends Constraint
{
    public string $message = 'cm.valid_territory_assignments';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
