<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\User\Domain\ResetPasswordRequestInterface;

interface AppResetPasswordRequestInterface extends ResetPasswordRequestInterface
{
    public function getAppUser(): AppUserInterface;
}
