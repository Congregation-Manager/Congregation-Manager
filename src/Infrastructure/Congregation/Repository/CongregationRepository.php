<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\Congregation;
use CongregationManager\Domain\Congregation\Model\CongregationInterface;
use CongregationManager\Domain\Congregation\Repository\CongregationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongregationInterface>
 *
 * @method CongregationInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongregationInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<CongregationInterface> findAll()
 * @method CongregationInterface[]    findAll()
 * @psalm-method list<CongregationInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method CongregationInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CongregationRepository extends ServiceEntityRepository implements CongregationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Congregation::class);
    }
}
