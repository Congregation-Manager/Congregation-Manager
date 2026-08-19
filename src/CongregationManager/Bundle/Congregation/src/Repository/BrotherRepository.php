<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Congregation\Repository;

use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Congregation\Domain\Repository\BrotherRepositoryInterface;
use CongregationManager\Component\Core\Domain\Brother;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<BrotherInterface>
 */
final class BrotherRepository extends ResourceRepository implements BrotherRepositoryInterface
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
