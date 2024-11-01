<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Application;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\AppUserInvitation;
use CongregationManager\Component\User\Domain\Generator\TokenGeneratorInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserInvitationRepositoryInterface;

final readonly class CreateAppUserInvitation
{
    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
        private AppUserInvitationRepositoryInterface $invitationRepository
    ) {
    }

    public function create(BrotherInterface $brother, string $email): AppUserInvitation
    {
        $appUserInvitation = new AppUserInvitation($brother, $email, $this->tokenGenerator->generate());
        $this->invitationRepository->add($appUserInvitation);

        return $appUserInvitation;
    }
}
