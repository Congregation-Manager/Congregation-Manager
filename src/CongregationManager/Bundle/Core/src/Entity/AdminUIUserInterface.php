<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Entity;

use CongregationManager\Bundle\User\Entity\UIUserInterface;
use CongregationManager\Component\Core\Domain\AdminUserInterface as DomainAdminUserInterface;

interface AdminUIUserInterface extends DomainAdminUserInterface, UIUserInterface
{
}
