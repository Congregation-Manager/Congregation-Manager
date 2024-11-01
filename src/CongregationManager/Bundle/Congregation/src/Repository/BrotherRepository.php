<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Repository;

use CongregationManager\Component\Congregation\Domain\Brother;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrotherInterface>
 *
 * @method BrotherInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrotherInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<BrotherInterface> findAll()
 *
 * @method BrotherInterface[] findAll()
 * @psalm-method list<BrotherInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method BrotherInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class BrotherRepository extends ServiceEntityRepository implements BrotherRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brother::class);
    }

    #[\Override]
    public function findOneById(int $id): ?BrotherInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(BrotherInterface $brother): void
    {
        $this->_em->persist($brother);
    }
}
