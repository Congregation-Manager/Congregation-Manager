<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Tests\Behat\Services\SharedStorageInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class TerritoryAssignmentContext implements Context
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
        $revocationDate = null !== $revocationDate ? new DateTimeImmutable($revocationDate) : null;
        $territoryAssignment = new TerritoryAssignment($territory, $assignmentDate, $brother);

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->entityManager->flush();

        $this->sharedStorage->set('territory_assignment', $territoryAssignment);
    }
}
