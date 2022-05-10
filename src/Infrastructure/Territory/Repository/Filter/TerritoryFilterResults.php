<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository\Filter;

use CongregationManager\Domain\Territory\Model\TerritoryInterface;
use CongregationManager\Domain\Territory\Repository\Filter\TerritoryFilterResultsInterface;
use Doctrine\ORM\QueryBuilder;
use Webmozart\Assert\Assert;

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
        $result = $qb->select('count(t.id)')->getQuery()->getSingleScalarResult();
        Assert::integer($result);

        return $result;
    }

    public function getResults(?int $limit = null, ?int $offset = null, ?string $sort = null, string $direction = 'ASC'): array
    {
        $qb = clone $this->queryBuilder;
        $qb = $qb->setFirstResult($offset)->setMaxResults($limit);
        if ($sort !== null) {
            $qb->orderBy($sort, $direction);
        }

        /** @var TerritoryInterface[] $results */
        $results = $qb->getQuery()->getResult();

        return $results;
    }
}
