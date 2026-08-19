<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Bundle\TerritoryManager\Repository\Filter\TerritoryFilterResults;
use CongregationManager\Component\Core\Domain\Territory;
use CongregationManager\Component\Core\Domain\TerritoryAssignment;
use CongregationManager\Component\TerritoryManager\Domain\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\TerritoryRepositoryInterface;
use CongregationManager\Component\TerritoryManager\Domain\TerritoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<TerritoryInterface>
 */
class TerritoryRepository extends ResourceRepository implements TerritoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Territory::class);
    }


    #[\Override]
    public function findOneById(AggregateRootId $id): ?TerritoryInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResults
    {
        $latestCompletedAssignmentQb = $this->_em->createQueryBuilder()
            ->select('MAX(ta_date_last_assignment.revocationDate)')
            ->from(TerritoryAssignment::class, 'ta_date_last_assignment')
            ->where('ta_date_last_assignment.territory = t.id')
            ->andWhere('ta_date_last_assignment.revocationDate IS NOT NULL')
            ->groupBy('ta_date_last_assignment.territory')
        ;

        $qb = $this->createQueryBuilder('t');
        $qb->join('t.area', 'a');
        $qb->leftJoin(
            't.territoryAssignments',
            'actual_assignment',
            Join::WITH,
            'actual_assignment.revocationDate IS NULL'
        );
        $qb->leftJoin(
            't.territoryAssignments',
            'latest_assignment',
            Join::WITH,
            $qb->expr()
                ->eq('latest_assignment.revocationDate', '(' . $latestCompletedAssignmentQb->getDQL() . ')')
        );
        if (count($filter->getAreas()) > 0) {
            $qb->andWhere('t.area IN (:areas)')
                ->setParameter('areas', $filter->getAreas())
            ;
        }
        if ($filter->isNotAssigned() !== null) {
            if ($filter->isNotAssigned()) {
                $qb->andWhere('actual_assignment.id is null');
            } else {
                $qb->andWhere('actual_assignment.id is not null');
            }
        }
        if ($filter->getAssignedTo() !== null) {
            $qb->andWhere('actual_assignment.recipient = :recipient')
                ->setParameter('recipient', $filter->getAssignedTo())
            ;
        }

        return new TerritoryFilterResults($qb);
    }

    #[\Override]
    public function findOneByNumber(int $number): ?TerritoryInterface
    {
        return $this->findOneBy([
            'number' => $number,
        ]);
    }

    #[\Override]
    public function add(TerritoryInterface $territory): void
    {
        $this->_em->persist($territory);
    }
}
