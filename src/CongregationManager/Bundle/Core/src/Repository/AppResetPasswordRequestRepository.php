<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Bundle\Core\Entity\AppResetPasswordRequest;
use CongregationManager\Component\Core\Domain\AppResetPasswordRequestInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AppResetPasswordRequestInterface>
 *
 * @method AppResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppResetPasswordRequestInterface|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @psalm-method list<AppResetPasswordRequestInterface> findAll()
 *
 * @method AppResetPasswordRequestInterface[] findAll()
 * @psalm-method list<AppResetPasswordRequestInterface> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 *
 * @method AppResetPasswordRequestInterface[] findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 */
class AppResetPasswordRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppResetPasswordRequest::class);
    }
}
