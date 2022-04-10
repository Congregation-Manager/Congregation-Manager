<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository;

use CongregationManager\Domain\Territory\Model\Area;
use CongregationManager\Domain\Territory\Model\AreaInterface;
use CongregationManager\Domain\Territory\Repository\AreaRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AreaInterface>
 *
 * @method AreaInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AreaInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AreaInterface> findAll()
 * @method AreaInterface[]    findAll()
 * @psalm-method list<AreaInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method AreaInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class AreaRepository extends ServiceEntityRepository implements AreaRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Area::class);
    }

    public function add(AreaInterface $area): void
    {
        $this->_em->persist($area);
    }
}
