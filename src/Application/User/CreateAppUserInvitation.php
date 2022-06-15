<?php

declare(strict_types=1);

namespace CongregationManager\Application\User;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\User\Generator\TokenGeneratorInterface;
use CongregationManager\Domain\User\Model\AppUserInvitation;
use CongregationManager\Domain\User\Repository\AppUserInvitationRepositoryInterface;

final class CreateAppUserInvitation
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
