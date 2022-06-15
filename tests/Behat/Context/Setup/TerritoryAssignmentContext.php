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
     */
    public function theTerritoryIsAssignedToBrother(TerritoryInterface $territory, BrotherInterface $brother): void
    {
        $territoryAssignment = new TerritoryAssignment($territory, new DateTimeImmutable(), $brother,);

        $this->territoryAssignmentRepository->add($territoryAssignment);
        $this->entityManager->flush();

        $this->sharedStorage->set('territory_assignment', $territoryAssignment);
    }
}
