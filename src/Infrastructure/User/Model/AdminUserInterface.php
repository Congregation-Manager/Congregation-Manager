<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\AdminUserInterface as DomainAdminUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface
{
}
