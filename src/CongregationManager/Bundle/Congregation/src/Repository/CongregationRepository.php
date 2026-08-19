<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Congregation\Domain\CongregationInterface;
use CongregationManager\Component\Congregation\Domain\Repository\CongregationRepositoryInterface;
use CongregationManager\Component\Core\Domain\Congregation;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<CongregationInterface>
 */
final class CongregationRepository extends ResourceRepository implements CongregationRepositoryInterface
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
