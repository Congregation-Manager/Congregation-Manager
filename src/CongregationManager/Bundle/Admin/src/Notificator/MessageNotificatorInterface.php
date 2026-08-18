<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Notificator;

use CongregationManager\Bundle\Core\Entity\AdminUIUserInterface;
use CongregationManager\Component\Core\Domain\AppUserInvitation;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordToken;

interface MessageNotificatorInterface
{
    public function notifyAppInvitation(AppUserInvitation $appUserInvitation, string $localeCode): void;

    public function notifyUserResetPasswordToken(
        AdminUIUserInterface $user,
        ResetPasswordToken   $resetPasswordToken,
        string               $localeCode,
    ): void;
}
