<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<TerritoryAssignmentInterface>
 */
final class TerritoryAssignmentRepository extends ResourceRepository implements TerritoryAssignmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerritoryAssignment::class);
    }

    #[\Override]
    public function add(TerritoryAssignmentInterface $territoryAssignment): void
    {
        $this->getEntityManager()
            ->persist($territoryAssignment);
    }

    #[\Override]
    public function findOneById(int $id): ?TerritoryAssignmentInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function flush(): void
    {
        $this->getEntityManager()
            ->flush();
    }
}
