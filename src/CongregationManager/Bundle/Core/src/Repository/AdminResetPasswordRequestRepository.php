<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Component\Core\Domain\AdminResetPasswordRequestInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AdminResetPasswordRequestInterface>
 *
 * @method AdminResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdminResetPasswordRequestInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AdminResetPasswordRequestInterface> findAll()
 *
 * @method AdminResetPasswordRequestInterface[] findAll()
 * @psalm-method list<AdminResetPasswordRequestInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method AdminResetPasswordRequestInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdminResetPasswordRequestRepository extends ServiceEntityRepository
{
}
