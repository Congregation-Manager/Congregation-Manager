<?php

declare(strict_types=1);

namespace CongregationManager\Domain\Territory\Generator;

use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Domain\Territory\S13\Page;
use CongregationManager\Domain\Territory\S13\Row;
use CongregationManager\Domain\Territory\S13\S13;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class S13Generator implements S13GeneratorInterface
{
    public function __construct(
        private readonly TerritoryRepositoryInterface $territoryRepository,
    ) {
    }

    public function generateByCongregation(CongregationInterface $congregation, int $theocraticYear): S13
    {
        $territories = $this->territoryRepository->findByCongregation($congregation);

        $s13 = new S13();
        $count = 1;
        $page = new Page($theocraticYear);
        foreach ($territories as $territory) {
            if ($count > Page::MAX_ROWS_ALLOWED) {
                $s13->addPage($page);
                $count = 1;
                $page = new Page($theocraticYear);
            }
            $row = new Row($territory);
            $lastAssignment = $this->getLastAssignmentOfPreviousTheocraticYear($territory, $theocraticYear);
            $row->setLastRevocationDate($lastAssignment?->getRevocationDate());
            $row->setTerritoryAssignments(
                $this->getLatestAssignmentsOfCurrentTheocraticYear($territory, $theocraticYear)
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
                static function (TerritoryAssignmentInterface $territoryAssignment) use ($currentTheocraticYear): bool {
                    return $territoryAssignment->getRevocationDate() !== null &&
                        $territoryAssignment->getRevocationDate() < new DateTimeImmutable(
                            $currentTheocraticYear - 1 . '-09-01'
                        );
                }
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
                static function (TerritoryAssignmentInterface $territoryAssignment) use ($currentTheocraticYear): bool {
                    return $territoryAssignment->getAssignmentDate() < new DateTimeImmutable(
                        $currentTheocraticYear . '-09-01'
                    ) &&
                        (
                            $territoryAssignment->getRevocationDate() === null ||
                            $territoryAssignment->getRevocationDate() > new DateTimeImmutable(
                                $currentTheocraticYear - 1 . '-08-31'
                            )
                        );
                }
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
