<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Behat\Services\SharedStorageInterface;
use CongregationManager\Component\Core\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final readonly class TerritoryAssignmentContext implements Context
{
    public function __construct(
        private SharedStorageInterface $sharedStorage,
        private TerritoryAssignmentRepositoryInterface $territoryAssignmentRepository,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @Given the territory :territory is assigned to brother :brother
     * @Given the territory :territory has been assigned to brother :brother on :assignmentDate
     * @Given the territory :territory has been assigned to brother :brother from :assignmentDate to :revocationDate
     */
    public function theTerritoryIsAssignedToBrother(
        TerritoryInterface $territory,
        BrotherInterface $brother,
        ?string $assignmentDate = null,
        ?string $revocationDate = null,
    ): void {
        $assignmentDate = new DateTimeImmutable($assignmentDate ?? 'now');
        $revocationDate = $revocationDate !== null ? new DateTimeImmutable($revocationDate) : null;
        $territoryAssignment = new TerritoryAssignment($territory, $assignmentDate, $brother);
        $territoryAssignment->setRevocationDate($revocationDate);

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->entityManager->flush();

        $this->sharedStorage->set('territory_assignment', $territoryAssignment);
    }
}
