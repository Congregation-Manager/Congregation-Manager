<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Component\Core\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryAssignmentRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryAssignmentInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerritoryAssignmentInterface>
 *
 * @method TerritoryAssignmentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerritoryAssignmentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<TerritoryAssignmentInterface> findAll()
 *
 * @method TerritoryAssignmentInterface[] findAll()
 * @psalm-method list<TerritoryAssignmentInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method TerritoryAssignmentInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TerritoryAssignmentRepository extends ServiceEntityRepository implements TerritoryAssignmentRepositoryInterface
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
