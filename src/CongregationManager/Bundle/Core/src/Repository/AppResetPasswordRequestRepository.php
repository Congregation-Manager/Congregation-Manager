<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Bundle\Core\Entity\AppResetPasswordRequest;
use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\AppResetPasswordRequestInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<AppResetPasswordRequestInterface>
 */
class AppResetPasswordRequestRepository extends ResourceRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AppResetPasswordRequest::class);
    }
}
