<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Tests\Domain;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class TerritoryTest extends TestCase
{
    private Territory $territory1;

    private TerritoryAssignment $territoryAssignment1;

    private TerritoryAssignment $territoryAssignment2;

    private TerritoryAssignment $territoryAssignment3;

    private TerritoryAssignment $territoryAssignment4;

    private Territory $territory2;

    protected function setUp(): void
    {
        $congregation = new Congregation('Carrollton');
        $province = new Province($congregation, 'Carrollton');
        $municipality = new Municipality($congregation, $province, 'Carrollton');
        $area = new Area($congregation, $municipality, 'Carrollton');
        $this->territory1 = new Territory($congregation, $area, 1);
        $this->territory2 = new Territory($congregation, $area, 2);
        $this->territoryAssignment1 = new TerritoryAssignment(
            $this->territory1,
            new DateTimeImmutable('2022-05-01'),
            null,
            new DateTimeImmutable('2022-05-20')
        );
        $this->territoryAssignment2 = new TerritoryAssignment(
            $this->territory1,
            new DateTimeImmutable('2022-09-01'),
            null,
            new DateTimeImmutable('2022-09-20')
        );
        $this->territoryAssignment3 = new TerritoryAssignment(
            $this->territory1,
            new DateTimeImmutable('2022-10-01'),
            null,
            new DateTimeImmutable('2022-10-20')
        );
        $this->territoryAssignment4 = new TerritoryAssignment(
            $this->territory1,
            new DateTimeImmutable('2022-12-01'),
            null,
            null
        );
        $this->territory1->addTerritoryAssignment($this->territoryAssignment4);
        $this->territory1->addTerritoryAssignment($this->territoryAssignment2);
        $this->territory1->addTerritoryAssignment($this->territoryAssignment3);
        $this->territory1->addTerritoryAssignment($this->territoryAssignment1);
    }

    public function testItReturnsSortedTerritoryAssignments(): void
    {
        $sortedTerritoryAssignments = $this->territory1->getSortedTerritoryAssignments();
        self::assertCount(4, $sortedTerritoryAssignments);
        self::assertEquals($this->territoryAssignment1, $sortedTerritoryAssignments->first());
        self::assertEquals($this->territoryAssignment2, $sortedTerritoryAssignments->next());
        self::assertEquals($this->territoryAssignment3, $sortedTerritoryAssignments->next());
        self::assertEquals($this->territoryAssignment4, $sortedTerritoryAssignments->next());
    }

    public function testItRetrievesLastRevocatedAssignment(): void
    {
        self::assertEquals($this->territoryAssignment3, $this->territory1->getLatestAssignment());
    }

    public function testItRetrievesCurrentAssignment(): void
    {
        self::assertEquals($this->territoryAssignment4, $this->territory1->getCurrentAssignment());
    }

    public function testItIsNotAvailable(): void
    {
        self::assertFalse($this->territory1->isAvailable());
    }

    public function testItDoesNotHaveAssignmentsBetweenDatesWhenTerritoryHasNoOtherAssignments(): void
    {
        self::assertFalse(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItDoesNotHaveAssignmentsStartingFromADateWhenTerritoryHasNoOtherAssignments(): void
    {
        self::assertFalse($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItDoesNotHaveAssignmentsBetweenDatesWhenTerritoryHasOnlyAPreviousOneAssignmentRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-01'
            )),
        );
        self::assertFalse(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItDoesNotHaveAssignmentsStartingFromADateWhenTerritoryHasOnlyAPreviousOneAssignmentRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-01'
            )),
        );
        self::assertFalse($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItDoesNotHaveAssignmentsBetweenDatesWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-30'
            )),
        );
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-07-01'), null, new DateTimeImmutable(
                '2022-08-01'
            )),
        );
        self::assertFalse(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-30'
            )),
        );
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-07-01'), null, new DateTimeImmutable(
                '2022-08-01'
            )),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItDoesNotHaveAssignmentsBetweenDatesWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOneWithoutEnds(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-01'
            )),
        );
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-07-01'), null, null),
        );
        self::assertFalse(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAPreviousOneAssignmentRevokedAndALaterOneWithoutEnds(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-04-01'
            )),
        );
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-07-01'), null, null),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAPreviousOneAssignmentThatHasNotBeenRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, null),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAPreviousOneAssignmentThatHasNotBeenRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, null),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAPreviousOneAssignmentRevokedDuringThePeriodOfTheNewOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-06-10'
            )),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAPreviousOneAssignmentRevokedDuringThePeriodOfTheNewOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-04-01'), null, new DateTimeImmutable(
                '2022-06-10'
            )),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndEndedLater(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-20'), null, new DateTimeImmutable(
                '2022-07-10'
            )),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndEndedLater(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-20'), null, new DateTimeImmutable(
                '2022-07-10'
            )),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndIsStillNotRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-20'), null, null),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAnAssignmentThatStartedDuringThePeriodOfTheNewOneAndIsStillNotRevoked(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-20'), null, null),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAnAssignmentWithinThePeriodOfTheNewOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-15'), null, new DateTimeImmutable(
                '2022-06-20'
            )),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAnAssignmentWithinThePeriodOfTheNewOne(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-15'), null, new DateTimeImmutable(
                '2022-06-20'
            )),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAnAssignmentWithTheSameDates(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-10'), null, new DateTimeImmutable(
                '2022-06-25'
            )),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItHasAssignmentsStartingFromADateWhenTerritoryHasAnAssignmentWithTheSameDates(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-10'), null, null),
        );
        self::assertTrue($this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10')));
    }

    public function testItHasAssignmentsBetweenDatesWhenTerritoryHasAnAssignmentStartedBeforeTheNewOneAndEndedLater(): void
    {
        $this->territory2->addTerritoryAssignment(
            new TerritoryAssignment($this->territory2, new DateTimeImmutable('2022-06-01'), null, new DateTimeImmutable(
                '2022-07-05'
            )),
        );
        self::assertTrue(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ))
        );
    }

    public function testItDoesNotHaveAssignmentsWhenTerritoryContainsTheSameInstance(): void
    {
        $territoryAssignment = new TerritoryAssignment($this->territory2, new DateTimeImmutable(
            '2022-06-10'
        ), null, new DateTimeImmutable('2022-06-25'));
        $this->territory2->addTerritoryAssignment($territoryAssignment,);
        self::assertFalse(
            $this->territory2->hasAssignmentBetweenDates(new DateTimeImmutable('2022-06-10'), new DateTimeImmutable(
                '2022-06-25'
            ), $territoryAssignment)
        );
    }
}
