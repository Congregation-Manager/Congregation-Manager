<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\User\Domain\ResetPasswordRequestInterface;

interface AdminResetPasswordRequestInterface extends ResetPasswordRequestInterface
{
    public function getAdminUser(): AdminUserInterface;
}
