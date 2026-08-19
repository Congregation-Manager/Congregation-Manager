<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\Area;
use CongregationManager\Component\TerritoryManager\Domain\AreaInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\AreaRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<AreaInterface>
 */
final class AreaRepository extends ResourceRepository implements AreaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Area::class);
    }

    #[\Override]
    public function findOneById(int $id): ?AreaInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(AreaInterface $area): void
    {
        $this->_em->persist($area);
    }
}
