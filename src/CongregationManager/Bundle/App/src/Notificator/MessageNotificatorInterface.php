<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\App\Notificator;

use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface MessageNotificatorInterface
{
    public function notifyUserResetPasswordToken(
        AppUIUserInterface $user,
        ResetPasswordToken $resetPasswordToken,
        string             $localeCode,
    ): void;
}
