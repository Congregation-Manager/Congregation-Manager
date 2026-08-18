<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Repository;

use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use CongregationManager\Component\Core\Domain\Congregation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CongregationInterface>
 *
 * @method CongregationInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method CongregationInterface|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @psalm-method list<CongregationInterface> findAll()
 *
 * @method CongregationInterface[] findAll()
 * @psalm-method list<CongregationInterface> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 *
 * @method CongregationInterface[] findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
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
