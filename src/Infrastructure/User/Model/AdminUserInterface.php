<?php

namespace App\Infrastructure\User\Model;

use App\Domain\User\Model\AdminUserInterface as DomainAdminUserInterface;

interface AdminUserInterface extends DomainAdminUserInterface, UserInterface
{
}
