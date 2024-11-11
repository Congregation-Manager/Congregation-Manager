<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Notificator;

use CongregationManager\Bundle\User\Entity\AppUserInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface MessageNotificatorInterface
{
    public function notifyUserResetPasswordToken(
        AppUserInterface $user,
        ResetPasswordToken $resetPasswordToken,
        string $localeCode,
    ): void;
}
