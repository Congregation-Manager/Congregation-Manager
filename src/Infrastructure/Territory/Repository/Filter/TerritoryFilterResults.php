<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Repository\Filter\TerritoryFilterResultsInterface;
use Doctrine\ORM\QueryBuilder;

final class TerritoryFilterResults implements TerritoryFilterResultsInterface
{
    public function __construct(
        private QueryBuilder $queryBuilder
    ) {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getTotalCount(): int
    {
        $qb = clone $this->queryBuilder;

        return $qb->select('count(t.id)')->getQuery()->getSingleScalarResult();
    }

    public function getResults(?int $limit = null, ?int $offset = null, ?string $sort = null, string $direction = 'ASC'): array
    {
        $qb = clone $this->queryBuilder;
        $qb = $qb->setFirstResult($offset)->setMaxResults($limit);
        if ($sort !== null) {
            $qb->orderBy($sort, $direction);
        }

        return $qb->getQuery()->getResult();
    }
}
