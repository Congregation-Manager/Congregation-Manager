<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Admin\Notificator;

use CongregationManager\Bundle\User\Entity\AppUserInvitation;

interface MessageNotificatorInterface
{
    public function notifyAppUserInvitation(AppUserInvitation $appUserInvitation, string $localeCode): void;
}
