<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Repository;

use CongregationManager\Domain\User\Model\AppUserInvitation;

interface AppUserInvitationRepositoryInterface
{
    public function add(AppUserInvitation $appUserInvitation): void;

    public function findByToken(string $token): ?AppUserInvitation;

    public function remove(AppUserInvitation $appUserInvitation): void;
}
