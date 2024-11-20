<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Component\Core\Domain\AppResetPasswordRequestInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<AppResetPasswordRequestInterface>
 *
 * @method AppResetPasswordRequestInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method AppResetPasswordRequestInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @psalm-method list<AppResetPasswordRequestInterface> findAll()
 *
 * @method AppResetPasswordRequestInterface[] findAll()
 * @psalm-method list<AppResetPasswordRequestInterface> findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 * @method AppResetPasswordRequestInterface[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppResetPasswordRequestRepository extends ServiceEntityRepository
{
}
