<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\Territory\Repository;

use CongregationManager\Domain\Territory\Model\Municipality;
use CongregationManager\Domain\Territory\Model\MunicipalityInterface;
use CongregationManager\Domain\Territory\Repository\MunicipalityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MunicipalityInterface>
 *
 * @method MunicipalityInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method MunicipalityInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<MunicipalityInterface> findAll()
 *
 * @method MunicipalityInterface[] findAll()
 * @psalm-method list<MunicipalityInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method MunicipalityInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class MunicipalityRepository extends ServiceEntityRepository implements MunicipalityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Municipality::class);
    }

    public function add(MunicipalityInterface $municipality): void
    {
        $this->_em->persist($municipality);
    }
}
