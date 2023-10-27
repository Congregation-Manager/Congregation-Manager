<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Tests\Domain;

use CongregationManager\Bundle\Resource\UuidV4;
use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
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

    private BrotherInterface $jhonBarrBrother;

    private TerritoryAssignment $territoryAssignmentWithRevocationDate;

    private TerritoryAssignment $territoryAssignmentWithoutRevocationDate;

    protected function setUp(): void
    {
        $congregation = new Congregation(new UuidV4(), 'congregation');
        $province = new Province($congregation, 'province');
        $municipality = new Municipality($congregation, $province, 'province');
        $this->territory = new Territory($congregation, new Area($congregation, $municipality, 'area'), 1);
        $this->jhonBarrBrother = new Brother('Jhon', 'Barr', $congregation);
        $this->territoryAssignmentWithRevocationDate = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            $this->jhonBarrBrother,
            new DateTimeImmutable('2022-06-25'),
        );
        $this->territoryAssignmentWithoutRevocationDate = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            $this->jhonBarrBrother,
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
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-31'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItDoesNotHaveSameDateToDifferentAssignmentWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment($this->territory, new DateTimeImmutable('2022-06-10'));
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithPreviousAssignmentDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
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
            $this->territory,
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithoutRevocationDateAndNotGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment($this->territory, new DateTimeImmutable('2022-06-08'));
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithoutRevocationDateAndGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment($this->territory, new DateTimeImmutable('2022-06-12'));
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }
}
