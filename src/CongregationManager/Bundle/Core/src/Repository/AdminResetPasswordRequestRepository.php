<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Component\Core\Domain\AdminResetPasswordRequestInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AdminResetPasswordRequestInterface>
 *
 * @method AdminResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminResetPasswordRequestInterface|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @psalm-method list<AdminResetPasswordRequestInterface> findAll()
 *
 * @method AdminResetPasswordRequestInterface[] findAll()
 * @psalm-method list<AdminResetPasswordRequestInterface> findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 *
 * @method AdminResetPasswordRequestInterface[] findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, int|null $limit = null, int|null $offset = null)
 */
class AdminResetPasswordRequestRepository extends ServiceEntityRepository
{
}
