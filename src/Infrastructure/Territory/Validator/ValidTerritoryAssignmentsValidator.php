<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Validator;

use CongregationManager\Application\Territory\Command\CreateTerritoryAssignment;
use CongregationManager\Application\Territory\Command\UpdateTerritoryAssignment;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Webmozart\Assert\Assert;

final class ValidTerritoryAssignmentsValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (! $constraint instanceof ValidTerritoryAssignments) {
            throw new UnexpectedTypeException($constraint, ValidTerritoryAssignments::class);
        }

        if ($value === null) {
            return;
        }

        if (! $value instanceof CreateTerritoryAssignment && ! $value instanceof UpdateTerritoryAssignment) {
            throw new UnexpectedValueException(
                $value,
                CreateTerritoryAssignment::class . '|' . UpdateTerritoryAssignment::class
            );
        }

        $territory = $value->getTerritory();
        if ($territory === null) {
            return;
        }
        Assert::notNull($value->getAssignmentDate());
        if ($territory->hasAssignmentBetweenDates(
            $value->getAssignmentDate(),
            $value->getRevocationDate(),
            $value instanceof UpdateTerritoryAssignment ? $value->getTerritoryAssignment() : null,
        )) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
