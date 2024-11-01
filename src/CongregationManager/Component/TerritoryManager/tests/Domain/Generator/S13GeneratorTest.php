<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Tests\Domain\Generator;

use CongregationManager\Component\Congregation\Domain\Congregation;
use CongregationManager\Component\TerritoryManager\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\Generator\S13Generator;
use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\S13\Page;
use CongregationManager\Component\TerritoryManager\Domain\S13\Row;
use CongregationManager\Component\TerritoryManager\Domain\Territory;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Infrastructure\Repository\InMemory\TerritoryRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class S13GeneratorTest extends TestCase
{
    private S13Generator $s13Generator;

    private TerritoryRepository $territoryRepository;

    private Congregation $carrolltonCongregation;

    private Territory $carrolltonTerritory1;

    private Territory $carrolltonTerritory2;

    private Territory $carrolltonTerritory3;

    private TerritoryAssignment $carrolltonTerritory1Assignment1;

    private TerritoryAssignment $carrolltonTerritory1Assignment2;

    private TerritoryAssignment $carrolltonTerritory1Assignment3;

    private TerritoryAssignment $carrolltonTerritory1Assignment4;

    private TerritoryAssignment $carrolltonTerritory2Assignment1;

    private TerritoryAssignment $carrolltonTerritory2Assignment2;

    private TerritoryAssignment $carrolltonTerritory2Assignment3;

    private TerritoryAssignment $carrolltonTerritory3Assignment1;

    private TerritoryAssignment $carrolltonTerritory3Assignment2;

    private TerritoryAssignment $carrolltonTerritory3Assignment3;

    private TerritoryAssignment $carrolltonTerritory3Assignment4;

    private TerritoryAssignment $carrolltonTerritory3Assignment5;

    private TerritoryAssignment $carrolltonTerritory3Assignment6;

    private TerritoryAssignment $carrolltonTerritory3Assignment7;

    #[\Override]
    protected function setUp(): void
    {
        $this->carrolltonCongregation = new Congregation('Carrollton');
        $province = new Province($this->carrolltonCongregation, 'Carrollton');
        $municipality = new Municipality($this->carrolltonCongregation, $province, 'Carrollton');
        $area = new Area($this->carrolltonCongregation, $municipality, 'Carrollton');

        $this->carrolltonTerritory1 = new Territory($this->carrolltonCongregation, $area, 1, 'Territory 1');
        $this->carrolltonTerritory1Assignment1 = new TerritoryAssignment(
            $this->carrolltonTerritory1,
            new DateTimeImmutable('2022-08-01'),
            null,
            new DateTimeImmutable('2022-08-31')
        );
        $carrolltonTerritory1Assignment0 = new TerritoryAssignment(
            $this->carrolltonTerritory1,
            new DateTimeImmutable('2022-05-01'),
            null,
            new DateTimeImmutable('2022-05-15')
        );
        $this->carrolltonTerritory1Assignment2 = new TerritoryAssignment(
            $this->carrolltonTerritory1,
            new DateTimeImmutable('2022-09-01'),
            null,
            new DateTimeImmutable('2022-09-31')
        );
        $this->carrolltonTerritory1Assignment3 = new TerritoryAssignment(
            $this->carrolltonTerritory1,
            new DateTimeImmutable('2022-11-01'),
            null,
            new DateTimeImmutable('2023-01-01')
        );
        $this->carrolltonTerritory1Assignment4 = new TerritoryAssignment(
            $this->carrolltonTerritory1,
            new DateTimeImmutable('2023-02-01'),
            null,
            new DateTimeImmutable('2023-02-18')
        );
        $this->carrolltonTerritory1->addTerritoryAssignment($this->carrolltonTerritory1Assignment1);
        $this->carrolltonTerritory1->addTerritoryAssignment($carrolltonTerritory1Assignment0);
        $this->carrolltonTerritory1->addTerritoryAssignment($this->carrolltonTerritory1Assignment2);
        $this->carrolltonTerritory1->addTerritoryAssignment($this->carrolltonTerritory1Assignment3);
        $this->carrolltonTerritory1->addTerritoryAssignment($this->carrolltonTerritory1Assignment4);

        $this->carrolltonTerritory2 = new Territory($this->carrolltonCongregation, $area, 2, 'Territory 2');
        $this->carrolltonTerritory2Assignment1 = new TerritoryAssignment(
            $this->carrolltonTerritory2,
            new DateTimeImmutable('2023-01-10'),
            null,
            new DateTimeImmutable('2023-01-31')
        );
        $this->carrolltonTerritory2Assignment2 = new TerritoryAssignment(
            $this->carrolltonTerritory2,
            new DateTimeImmutable('2023-05-01'),
            null,
            new DateTimeImmutable('2023-05-30')
        );
        $this->carrolltonTerritory2Assignment3 = new TerritoryAssignment(
            $this->carrolltonTerritory2,
            new DateTimeImmutable('2023-07-01'),
            null,
            null
        );
        $this->carrolltonTerritory2->addTerritoryAssignment($this->carrolltonTerritory2Assignment1);
        $this->carrolltonTerritory2->addTerritoryAssignment($this->carrolltonTerritory2Assignment2);
        $this->carrolltonTerritory2->addTerritoryAssignment($this->carrolltonTerritory2Assignment3);

        $this->carrolltonTerritory3 = new Territory($this->carrolltonCongregation, $area, 3, 'Territory 3');
        $this->carrolltonTerritory3Assignment1 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2022-07-03'),
            null,
            new DateTimeImmutable('2022-07-28')
        );
        $this->carrolltonTerritory3Assignment2 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2022-08-20'),
            null,
            new DateTimeImmutable('2022-10-25')
        );
        $this->carrolltonTerritory3Assignment3 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2022-12-01'),
            null,
            new DateTimeImmutable('2022-12-25')
        );
        $this->carrolltonTerritory3Assignment4 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2023-04-01'),
            null,
            new DateTimeImmutable('2023-04-25')
        );
        $this->carrolltonTerritory3Assignment5 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2023-05-01'),
            null,
            new DateTimeImmutable('2023-05-25')
        );
        $this->carrolltonTerritory3Assignment6 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2023-06-01'),
            null,
            new DateTimeImmutable('2023-06-25')
        );
        $this->carrolltonTerritory3Assignment7 = new TerritoryAssignment(
            $this->carrolltonTerritory3,
            new DateTimeImmutable('2023-07-01'),
            null,
            new DateTimeImmutable('2023-07-25')
        );
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment1);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment2);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment3);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment4);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment5);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment6);
        $this->carrolltonTerritory3->addTerritoryAssignment($this->carrolltonTerritory3Assignment7);

        $this->territoryRepository = new TerritoryRepository();
        $this->territoryRepository->territories = [
            $this->carrolltonTerritory1,
            $this->carrolltonTerritory2,
            $this->carrolltonTerritory3,
        ];
        $this->generateTerritories(50, $this->carrolltonCongregation, $area, 4);
        $this->s13Generator = new S13Generator($this->territoryRepository);
    }

    public function testItGeneratesS13Successfully(): void
    {
        $s13 = $this->s13Generator->generateByCongregation($this->carrolltonCongregation, 2023);
        self::assertCount(3, $s13->getPages());

        $firstPage = $s13->getPages()
            ->first();
        self::assertInstanceOf(Page::class, $firstPage);
        self::assertEquals(2023, $firstPage->getServiceYear());
        self::assertCount(20, $firstPage->getRows());
        $secondPage = $s13->getPages()
            ->get(1);
        self::assertInstanceOf(Page::class, $secondPage);
        self::assertCount(20, $secondPage->getRows());
        $thirdPage = $s13->getPages()
            ->get(2);
        self::assertInstanceOf(Page::class, $thirdPage);
        self::assertCount(10, $thirdPage->getRows());

        $territory1Row = $firstPage->getRows()
            ->get(0);
        self::assertInstanceOf(Row::class, $territory1Row);
        self::assertEquals($this->carrolltonTerritory1, $territory1Row->getTerritory());
        self::assertEquals(
            $this->carrolltonTerritory1Assignment1->getRevocationDate(),
            $territory1Row->getLastRevocationDate()
        );
        self::assertEquals($this->carrolltonTerritory1Assignment2, $territory1Row->getTerritoryAssignments()->get(1));
        self::assertEquals($this->carrolltonTerritory1Assignment3, $territory1Row->getTerritoryAssignments()->get(2));
        self::assertEquals($this->carrolltonTerritory1Assignment4, $territory1Row->getTerritoryAssignments()->get(3));
        self::assertNull($territory1Row->getTerritoryAssignments()->get(4));

        $territory2Row = $firstPage->getRows()
            ->get(1);
        self::assertInstanceOf(Row::class, $territory2Row);
        self::assertEquals($this->carrolltonTerritory2, $territory2Row->getTerritory());
        self::assertNull($territory2Row->getLastRevocationDate());
        self::assertEquals($this->carrolltonTerritory2Assignment1, $territory2Row->getTerritoryAssignments()->get(1));
        self::assertEquals($this->carrolltonTerritory2Assignment2, $territory2Row->getTerritoryAssignments()->get(2));
        self::assertEquals($this->carrolltonTerritory2Assignment3, $territory2Row->getTerritoryAssignments()->get(3));
        self::assertNull($territory2Row->getTerritoryAssignments()->get(4));

        $territory3Row = $firstPage->getRows()
            ->get(2);
        self::assertInstanceOf(Row::class, $territory3Row);
        self::assertEquals($this->carrolltonTerritory3, $territory3Row->getTerritory());
        self::assertEquals(
            $this->carrolltonTerritory3Assignment1->getRevocationDate(),
            $territory3Row->getLastRevocationDate()
        );
        self::assertEquals($this->carrolltonTerritory3Assignment4, $territory3Row->getTerritoryAssignments()->get(1));
        self::assertEquals($this->carrolltonTerritory3Assignment5, $territory3Row->getTerritoryAssignments()->get(2));
        self::assertEquals($this->carrolltonTerritory3Assignment6, $territory3Row->getTerritoryAssignments()->get(3));
        self::assertEquals($this->carrolltonTerritory3Assignment7, $territory3Row->getTerritoryAssignments()->get(4));
    }

    private function generateTerritories(int $num, Congregation $congregation, Area $area, int $startFrom = 1): void
    {
        for ($startFrom; $startFrom <= $num; $startFrom++) {
            $territory = new Territory($congregation, $area, $startFrom, 'Territory ' . $startFrom);
            $this->territoryRepository->add($territory);
        }
    }
}
