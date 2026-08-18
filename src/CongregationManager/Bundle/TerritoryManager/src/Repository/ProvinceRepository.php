<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\TerritoryManager\Repository;

use CongregationManager\Component\Core\Domain\Province;
use CongregationManager\Component\TerritoryManager\Domain\ProvinceInterface;
use CongregationManager\Component\TerritoryManager\Domain\Repository\ProvinceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProvinceInterface>
 *
 * @method ProvinceInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProvinceInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<ProvinceInterface> findAll()
 *
 * @method ProvinceInterface[] findAll()
 * @psalm-method list<ProvinceInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method ProvinceInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProvinceRepository extends ServiceEntityRepository implements ProvinceRepositoryInterface
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
