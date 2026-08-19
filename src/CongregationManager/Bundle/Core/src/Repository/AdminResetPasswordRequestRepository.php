<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Repository;

use CongregationManager\Bundle\Core\Entity\AdminResetPasswordRequest;
use CongregationManager\Bundle\Resource\Repository\ResourceRepository;
use CongregationManager\Component\Core\Domain\AdminResetPasswordRequestInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ResourceRepository<AdminResetPasswordRequestInterface>
 */
class AdminResetPasswordRequestRepository extends ResourceRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AdminResetPasswordRequest::class);
    }
}
