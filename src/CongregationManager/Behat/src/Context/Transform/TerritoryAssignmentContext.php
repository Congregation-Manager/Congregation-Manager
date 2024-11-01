<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Transform;

use Behat\Behat\Context\Context;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use Webmozart\Assert\Assert;

final readonly class TerritoryAssignmentContext implements Context
{
    public function __construct(
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
        private TerritoryRepositoryInterface $territoryRepository,
        private BrotherRepositoryInterface $brotherRepository,
    ) {
    }

    /**
     * @Transform /^assignment of territory "([^"]+)" of "([^"]+)" starting on "([^"]+)"$/
     */
    public function getTerritoryByNumber(
        int $territoryNumber,
        string $brotherFullName,
        string $assignmentDate
    ): TerritoryAssignmentInterface {
        $territory = $this->territoryRepository->findOneByNumber($territoryNumber);
        Assert::isInstanceOf($territory, TerritoryInterface::class);

        [$firstName, $lastName] = explode(' ', $brotherFullName);
        $brother = $this->brotherRepository->findOneBy([
            'firstName' => $firstName,
            'lastName' => $lastName,
        ]);
        Assert::isInstanceOf($brother, BrotherInterface::class);

        $territoryAssignments = $this->territoryAssignmentRepository->findAll();
        $territoryAssignments = array_filter(
            $territoryAssignments,
            static fn ($territoryAssignment) => $territoryAssignment->getTerritory() === $territory
            && $territoryAssignment->getBrother() === $brother
            && $territoryAssignment->getAssignmentDate()
                ->format('Y-m-d') === $assignmentDate
        );
        $territoryAssignment = reset($territoryAssignments);
        Assert::isInstanceOf($territoryAssignment, TerritoryAssignmentInterface::class);

        return $territoryAssignment;
    }
}
