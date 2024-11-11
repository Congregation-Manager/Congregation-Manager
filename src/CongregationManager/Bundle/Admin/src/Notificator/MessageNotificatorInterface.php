<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Notificator;

use CongregationManager\Bundle\User\Entity\AdminUserInterface;
use CongregationManager\Bundle\User\Entity\AppUserInvitation;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface MessageNotificatorInterface
{
    public function notifyAppUserInvitation(AppUserInvitation $appUserInvitation, string $localeCode): void;

    public function notifyAdminUserNotifyToken(
        AdminUserInterface $user,
        ResetPasswordToken $resetPasswordToken,
        string $localeCode,
    ): void;
}
