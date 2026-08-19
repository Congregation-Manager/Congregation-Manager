<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\MunicipalityRepositoryInterface;
use CongregationManager\Contract\Resource\AggregateRootId;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<MunicipalityInterface>
 */
final class MunicipalityRepository extends ResourceRepository implements MunicipalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }

    #[\Override]
    public function findOneById(AggregateRootId $id): ?MunicipalityInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(MunicipalityInterface $municipality): void
    {
        $this->_em->persist($municipality);
    }
}
