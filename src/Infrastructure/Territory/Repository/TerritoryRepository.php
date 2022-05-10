<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository;

use CongregationManager\Domain\Territory\Model\Territory;
use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryRepositoryFilterInterface;
use CongregationManager\Domain\Territory\Repository\TerritoryRepositoryInterface;
use CongregationManager\Infrastructure\Territory\Repository\Filter\TerritoryFilterResults;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerritoryInterface>
 *
 * @method TerritoryInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerritoryInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<TerritoryInterface> findAll()
 * @method TerritoryInterface[]    findAll()
 * @psalm-method list<TerritoryInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method TerritoryInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class TerritoryRepository extends ServiceEntityRepository implements TerritoryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Territory::class);
    }

    public function add(TerritoryInterface $territory): void
    {
        $this->_em->persist($territory);
    }

    public function filter(TerritoryRepositoryFilterInterface $filter): TerritoryFilterResults
    {
        $qb = $this->createQueryBuilder('t');
        $qb->join('t.area', 'a');
        if (count($filter->getAreas()) > 0) {
            $qb->andWhere('t.area IN (:areas)')->setParameter('areas', $filter->getAreas());
        }

        return new TerritoryFilterResults($qb);
    }
}
