<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Repository;

use CongregationManager\Bundle\Core\Entity\Congregation;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongregationInterface>
 *
 * @method CongregationInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongregationInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<CongregationInterface> findAll()
 *
 * @method CongregationInterface[] findAll()
 * @psalm-method list<CongregationInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method CongregationInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class CongregationRepository extends ServiceEntityRepository implements CongregationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Congregation::class);
    }

    #[\Override]
    public function findOneById(int $id): ?CongregationInterface
    {
        return $this->find($id);
    }

    #[\Override]
    public function add(CongregationInterface $congregation): void
    {
        $this->_em->persist($congregation);
    }
}
