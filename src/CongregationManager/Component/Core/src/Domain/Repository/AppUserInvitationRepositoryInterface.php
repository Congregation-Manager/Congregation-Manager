<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Repository;

use CongregationManager\Component\Core\Domain\AppUserInvitation;

interface AppUserInvitationRepositoryInterface
{
    public function add(AppUserInvitation $appUserInvitation): void;

    public function findByToken(string $token): ?AppUserInvitation;

    public function remove(AppUserInvitation $appUserInvitation): void;
}
