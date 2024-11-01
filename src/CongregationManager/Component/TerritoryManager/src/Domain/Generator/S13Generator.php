<?php

declare(strict_types=1);

namespace CongregationManager\Component\TerritoryManager\Domain\Generator;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\S13\Page;
use CongregationManager\Component\TerritoryManager\Domain\S13\Row;
use CongregationManager\Component\TerritoryManager\Domain\S13\S13;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final readonly class S13Generator implements S13GeneratorInterface
{
    public function __construct(
        private TerritoryRepositoryInterface $territoryRepository,
    ) {
    }

    #[\Override]
    public function generateByCongregation(CongregationInterface $congregation, int $serviceYear): S13
    {
        $territories = $this->territoryRepository->findByCongregation($congregation);

        $s13 = new S13();
        $count = 1;
        $page = new Page($serviceYear);
        foreach ($territories as $territory) {
            if ($count > Page::MAX_ROWS_ALLOWED) {
                $s13->addPage($page);
                $count = 1;
                $page = new Page($serviceYear);
            }
            $row = new Row($territory);
            $lastAssignment = $this->getLastAssignmentOfPreviousTheocraticYear($territory, $serviceYear);
            $row->setLastRevocationDate($lastAssignment?->getRevocationDate());
            $row->setTerritoryAssignments(
                $this->getLatestAssignmentsOfCurrentTheocraticYear($territory, $serviceYear)
            );
            $page->addRow($row);
            $count++;
        }
        if ($page->getRows()->count() > 0) {
            $s13->addPage($page);
        }

        return $s13;
    }

    private function getLastAssignmentOfPreviousTheocraticYear(
        TerritoryInterface $territory,
        int $currentTheocraticYear
    ): ?TerritoryAssignmentInterface {
        $territoryAssignments = $territory->getSortedTerritoryAssignments();
        if ($territoryAssignments->count() === 0) {
            return null;
        }
        $territoryAssignmentsBeforeCurrentTheocraticYear = $territoryAssignments
            ->filter(
                static fn (TerritoryAssignmentInterface $territoryAssignment): bool => $territoryAssignment->getRevocationDate() !== null &&
                    $territoryAssignment->getRevocationDate() < new DateTimeImmutable(
                        $currentTheocraticYear - 1 . '-09-01'
                    )
            );
        if ($territoryAssignmentsBeforeCurrentTheocraticYear->count() === 0) {
            return null;
        }

        $last = $territoryAssignmentsBeforeCurrentTheocraticYear->last();
        if ($last === false) {
            return null;
        }

        return $last;
    }

    /**
     * @return Collection<int, TerritoryAssignmentInterface>
     */
    private function getLatestAssignmentsOfCurrentTheocraticYear(
        TerritoryInterface $territory,
        int $currentTheocraticYear
    ): Collection {
        /** @var ArrayCollection<int, TerritoryAssignmentInterface> $latestAssignmentOfCurrentTheocraticYear */
        $latestAssignmentOfCurrentTheocraticYear = new ArrayCollection();
        $territoryAssignments = $territory->getSortedTerritoryAssignments();
        if ($territoryAssignments->count() === 0) {
            return $latestAssignmentOfCurrentTheocraticYear;
        }
        $territoryAssignmentsOfCurrentTheocraticYear = $territoryAssignments
            ->filter(
                static fn (TerritoryAssignmentInterface $territoryAssignment): bool => $territoryAssignment->getAssignmentDate() < new DateTimeImmutable(
                    $currentTheocraticYear . '-09-01'
                ) &&
                    (
                        $territoryAssignment->getRevocationDate() === null ||
                        $territoryAssignment->getRevocationDate() > new DateTimeImmutable(
                            $currentTheocraticYear - 1 . '-08-31'
                        )
                    )
            )
        ;
        if ($territoryAssignmentsOfCurrentTheocraticYear->count() === 0) {
            return $latestAssignmentOfCurrentTheocraticYear;
        }
        $last4territoryAssignmentsOfCurrentTheocraticYear = $territoryAssignmentsOfCurrentTheocraticYear->slice(
            -Row::MAX_COLUMNS_ALLOWED,
            Row::MAX_COLUMNS_ALLOWED
        );

        $key = 1;
        foreach ($last4territoryAssignmentsOfCurrentTheocraticYear as $territoryAssignment) {
            $latestAssignmentOfCurrentTheocraticYear->set($key, $territoryAssignment);
            $key++;
        }

        return $latestAssignmentOfCurrentTheocraticYear;
    }
}
