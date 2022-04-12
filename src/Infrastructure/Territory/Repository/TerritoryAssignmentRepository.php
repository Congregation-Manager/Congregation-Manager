<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository;

use CongregationManager\Domain\Territory\Model\TerritoryAssignment;
use CongregationManager\Domain\Territory\Model\TerritoryAssignmentInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryAssignmentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerritoryAssignmentInterface>
 *
 * @method TerritoryAssignmentInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerritoryAssignmentInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<TerritoryAssignmentInterface> findAll()
 * @method TerritoryAssignmentInterface[]    findAll()
 * @psalm-method list<TerritoryAssignmentInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method TerritoryAssignmentInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TerritoryAssignmentRepository extends ServiceEntityRepository implements TerritoryAssignmentRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerritoryAssignment::class);
    }

    public function add(TerritoryAssignmentInterface $territoryAssignment): void
    {
        $this->_em->persist($territoryAssignment);
    }
}
