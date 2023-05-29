<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Entity;

use CongregationManager\Component\User\Domain\AdminUserInterface as DomainAdminUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface
{
}
