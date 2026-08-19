<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Tests\Domain;

use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\IntegerAggregateRootId;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @internal
 */
final class TerritoryAssignmentTest extends TestCase
{
    use ProphecyTrait;

    private TerritoryInterface $territory;

    private TerritoryAssignment $territoryAssignmentWithRevocationDate;

    private TerritoryAssignment $territoryAssignmentWithoutRevocationDate;

    #[\Override]
    protected function setUp(): void
    {
        $province = new Province(new IntegerAggregateRootId(1), 'province');
        $municipality = new Municipality(new IntegerAggregateRootId(2), $province, 'province');
        $this->territory = new Territory(new IntegerAggregateRootId(3), new Area(new IntegerAggregateRootId(
            4
        ), $municipality, 'area'), 1);
        $jhonBarrBrother = new Recipient();
        $this->territoryAssignmentWithRevocationDate = new TerritoryAssignment(
            new IntegerAggregateRootId(5),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            $jhonBarrBrother,
            new DateTimeImmutable('2022-06-25'),
        );
        $this->territoryAssignmentWithoutRevocationDate = new TerritoryAssignment(
            new IntegerAggregateRootId(6),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            $jhonBarrBrother,
            null,
        );
    }

    public function testItHasSameDateToSameAssignment(): void
    {
        self::assertTrue(
            $this->territoryAssignmentWithRevocationDate->hasSameDatesTo(
                $this->territoryAssignmentWithRevocationDate
            )
        );
    }

    public function testItHasSameDateToDifferentAssignmentWithSameDates(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(7),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItDoesNotHaveSameDateToDifferentAssignmentWithDifferentDates(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(8),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-31'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItDoesNotHaveSameDateToDifferentAssignmentWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(new IntegerAggregateRootId(
            9
        ), $this->territory, new DateTimeImmutable('2022-06-10'));
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithPreviousAssignmentDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(10),
            $this->territory,
            new DateTimeImmutable('2022-06-08'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithPreviousRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(11),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-24'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(12),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            null,
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithGreaterRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(13),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-26'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithGreaterAssignmentDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(14),
            $this->territory,
            new DateTimeImmutable('2022-06-11'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithSameDates(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(15),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanSameAssignment(): void
    {
        self::assertFalse(
            $this->territoryAssignmentWithRevocationDate->isGreaterThan(
                $this->territoryAssignmentWithRevocationDate
            )
        );
    }

    public function testItIsNotGreaterThanAssignmentWithSameDatesIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(16),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            null,
        );
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithDatesIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            new IntegerAggregateRootId(17),
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithoutRevocationDateAndNotGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(new IntegerAggregateRootId(
            18
        ), $this->territory, new DateTimeImmutable('2022-06-08'));
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithoutRevocationDateAndGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(new IntegerAggregateRootId(
            19
        ), $this->territory, new DateTimeImmutable('2022-06-12'));
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }
}
