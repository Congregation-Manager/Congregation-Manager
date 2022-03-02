<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Congregation\Repository;

use CongregationManager\Domain\Congregation\Model\Brother;
use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\Congregation\Repository\BrotherRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrotherInterface>
 *
 * @method BrotherInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrotherInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<BrotherInterface> findAll()
 * @method BrotherInterface[]    findAll()
 * @psalm-method list<BrotherInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method BrotherInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BrotherRepository extends ServiceEntityRepository implements BrotherRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brother::class);
    }

    public function add(Brother $brother): void
    {
        $this->_em->persist($brother);
    }
}
