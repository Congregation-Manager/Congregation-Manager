<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Domain\Territory\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;

/**
 * @internal
 * @coversNothing
 */
final class TerritoryAssignmentTest extends TestCase
{
    use ProphecyTrait;

    private ObjectProphecy|TerritoryInterface $territory;

    private ObjectProphecy|BrotherInterface $jhonBarrBrother;

    private TerritoryAssignment $territoryAssignmentWithRevocationDate;

    private TerritoryAssignment $territoryAssignmentWithoutRevocationDate;

    protected function setUp(): void
    {
        $this->territory = $this->prophesize(TerritoryInterface::class);
        $this->jhonBarrBrother = $this->prophesize(BrotherInterface::class);
        $this->territoryAssignmentWithRevocationDate = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            $this->jhonBarrBrother->reveal(),
            new DateTimeImmutable('2022-06-25'),
        );
        $this->territoryAssignmentWithoutRevocationDate = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            $this->jhonBarrBrother->reveal(),
            null,
        );
    }

    public function testAssignmentWithRevocationDateIsValidWhenTerritoryHasNoOtherAssignments(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection())
        ;
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsValidWhenTerritoryHasNoOtherAssignments(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection())
        ;
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsValidWhenTerritoryHasOnlyAPreviousOneAssignmentRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-01')),
            ]))
        ;
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsValidWhenTerritoryHasOnlyAPreviousOneAssignmentRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-01')),
            ]))
        ;
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsValidWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-30')),
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-07-01'
                ), null, new DateTimeImmutable('2022-08-01')),
            ]))
        ;
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsNotValidWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-30')),
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-07-01'
                ), null, new DateTimeImmutable('2022-08-01')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsValidWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOneWithoutEnds(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-01')),
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-07-01'
                ), null, null),
            ]))
        ;
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsNotValidWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOneWithoutEnds(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-04-01')),
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-07-01'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAPreviousOneAssignmentThatHasNotBeenRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAPreviousOneAssignmentThatHasNotBeenRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAPreviousOneAssignmentRevokedDuringThePeriodOfTheNewOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-06-10')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAPreviousOneAssignmentRevokedDuringThePeriodOfTheNewOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-04-01'
                ), null, new DateTimeImmutable('2022-06-10')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndEndedLater(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-20'
                ), null, new DateTimeImmutable('2022-07-10')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndEndedLater(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-20'
                ), null, new DateTimeImmutable('2022-07-10')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndIsStillNotRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-20'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndIsStillNotRevoked(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-20'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAnAssignmentWithinThePeriodOfTheNewOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-15'
                ), null, new DateTimeImmutable('2022-06-20')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAnAssignmentWithinThePeriodOfTheNewOne(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-15'
                ), null, new DateTimeImmutable('2022-06-20')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAnAssignmentWithTheSameDates(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-10'
                ), null, new DateTimeImmutable('2022-06-25')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentWithoutRevocationDateIsInvalidWhenTerritoryHasAnAssignmentWithTheSameDates(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-10'
                ), null, null),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isValid());
    }

    public function testAssignmentWithRevocationDateIsInvalidWhenTerritoryHasAnAssignmentStartedBeforeTheNewOneAndEndedLater(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([
                new TerritoryAssignment($this->territory->reveal(), new DateTimeImmutable(
                    '2022-06-01'
                ), null, new DateTimeImmutable('2022-07-05')),
            ]))
        ;
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isValid());
    }

    public function testAssignmentIsValidWhenTerritoryContainsTheSameInstance(): void
    {
        $this->territory->getTerritoryAssignments()
            ->willReturn(new ArrayCollection([$this->territoryAssignmentWithRevocationDate]))
        ;
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isValid());
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
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItDoesNotHaveSameDateToDifferentAssignmentWithDifferentDates(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-31'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItDoesNotHaveSameDateToDifferentAssignmentWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->hasSameDatesTo($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithPreviousAssignmentDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-08'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithPreviousRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-24'),
        );
        self::assertTrue($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            null,
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithGreaterRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-26'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithGreaterAssignmentDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-11'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertFalse($this->territoryAssignmentWithRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithSameDates(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
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
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            null,
        );
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithDatesIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-10'),
            null,
            new DateTimeImmutable('2022-06-25'),
        );
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsGreaterThanAssignmentWithoutRevocationDateAndNotGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-08'),
        );
        self::assertTrue($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }

    public function testItIsNotGreaterThanAssignmentWithoutRevocationDateAndGreaterAssignmentDateIfWithoutRevocationDate(): void
    {
        $otherAssignment = new TerritoryAssignment(
            $this->territory->reveal(),
            new DateTimeImmutable('2022-06-12'),
        );
        self::assertFalse($this->territoryAssignmentWithoutRevocationDate->isGreaterThan($otherAssignment));
    }
}
