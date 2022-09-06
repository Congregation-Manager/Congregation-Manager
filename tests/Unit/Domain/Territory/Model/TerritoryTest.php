<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Unit\Domain\Territory\Model;

use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Domain\Territory\Model\Municipality;
use CongregationManager\Domain\Territory\Model\Province;
use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

final class TerritoryTest extends TestCase
{
    private Territory $territory;

    private TerritoryAssignment $territoryAssignment1;

    private TerritoryAssignment $territoryAssignment2;

    private TerritoryAssignment $territoryAssignment3;

    protected function setUp(): void
    {
        $congregation = new Congregation('Carrollton');
        $province = new Province($congregation, 'Carrollton');
        $municipality = new Municipality($congregation, $province, 'Carrollton');
        $area = new Area($congregation, $municipality, 'Carrollton');
        $this->territory = new Territory($congregation, $area, 1);
        $this->territoryAssignment1 = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-05-01'),
            null,
            new DateTimeImmutable('2022-05-20')
        );
        $this->territoryAssignment2 = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-09-01'),
            null,
            new DateTimeImmutable('2022-09-20')
        );
        $this->territoryAssignment3 = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-10-01'),
            null,
            new DateTimeImmutable('2022-10-20')
        );
        $this->territoryAssignment4 = new TerritoryAssignment(
            $this->territory,
            new DateTimeImmutable('2022-12-01'),
            null,
            null
        );
        $this->territory->addTerritoryAssignment($this->territoryAssignment4);
        $this->territory->addTerritoryAssignment($this->territoryAssignment2);
        $this->territory->addTerritoryAssignment($this->territoryAssignment3);
        $this->territory->addTerritoryAssignment($this->territoryAssignment1);
    }

    public function testItReturnsSortedTerritoryAssignments(): void
    {
        $sortedTerritoryAssignments = $this->territory->getSortedTerritoryAssignments();
        self::assertCount(4, $sortedTerritoryAssignments);
        self::assertEquals($this->territoryAssignment1, $sortedTerritoryAssignments->first());
        self::assertEquals($this->territoryAssignment2, $sortedTerritoryAssignments->next());
        self::assertEquals($this->territoryAssignment3, $sortedTerritoryAssignments->next());
        self::assertEquals($this->territoryAssignment4, $sortedTerritoryAssignments->next());
    }

    public function testItRetrievesLastRevocatedAssignment(): void
    {
        self::assertEquals($this->territoryAssignment3, $this->territory->getLatestAssignment());
    }

    public function testItRetrievesCurrentAssignment(): void
    {
        self::assertEquals($this->territoryAssignment4, $this->territory->getCurrentAssignment());
    }

    public function testItIsNotAvailable(): void
    {
        self::assertFalse($this->territory->isAvailable());
    }
}
