<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Component\TerritoryManager\Domain\Municipality;
use CongregationManager\Component\TerritoryManager\Domain\MunicipalityInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\MunicipalityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MunicipalityInterface>
 *
 * @method MunicipalityInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method MunicipalityInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<MunicipalityInterface> findAll()
 *
 * @method MunicipalityInterface[] findAll()
 * @psalm-method list<MunicipalityInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method MunicipalityInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MunicipalityRepository extends ServiceEntityRepository implements MunicipalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }

    #[\Override]
    public function findOneById(int $id): ?MunicipalityInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(MunicipalityInterface $municipality): void
    {
        $this->_em->persist($municipality);
    }
}
