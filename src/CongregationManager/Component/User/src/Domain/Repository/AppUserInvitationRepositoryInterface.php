<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain\Repository;

use CongregationManager\Component\User\Domain\AppUserInvitation;

interface AppUserInvitationRepositoryInterface
{
    public function add(AppUserInvitation $appUserInvitation): void;

    public function findByToken(string $token): ?AppUserInvitation;

    public function remove(AppUserInvitation $appUserInvitation): void;
}
