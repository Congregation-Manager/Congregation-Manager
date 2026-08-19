<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\ProvinceRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<ProvinceInterface>
 */
final class ProvinceRepository extends ResourceRepository implements ProvinceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Province::class);
    }

    #[\Override]
    public function findOneById(int $id): ?ProvinceInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(ProvinceInterface $province): void
    {
        $this->_em->persist($province);
    }
}
