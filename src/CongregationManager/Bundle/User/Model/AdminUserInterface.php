<?php

declare(strict_types=1);

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Component\User\Domain\AdminUserInterface as DomainAdminUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface
{
}
