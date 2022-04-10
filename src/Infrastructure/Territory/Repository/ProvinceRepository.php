<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository;

use CongregationManager\Domain\Territory\Model\Province;
use CongregationManager\Domain\Territory\Model\ProvinceInterface;
use CongregationManager\Domain\Territory\Repository\ProvinceRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProvinceInterface>
 *
 * @method ProvinceInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProvinceInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<ProvinceInterface> findAll()
 * @method ProvinceInterface[]    findAll()
 * @psalm-method list<ProvinceInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method ProvinceInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProvinceRepository extends ServiceEntityRepository implements ProvinceRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Province::class);
    }

    public function add(ProvinceInterface $province): void
    {
        $this->_em->persist($province);
    }
}
