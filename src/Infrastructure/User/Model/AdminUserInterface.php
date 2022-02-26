<?php

namespace CongregationManager\Infrastructure\User\Model;

use CongregationManager\Domain\User\Model\AdminUserInterface as DomainAdminUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface
{
}
