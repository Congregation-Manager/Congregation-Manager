<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Action;

use CongregationManager\Bundle\Core\Entity\AppUserInvitation;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\Repository\AppUserInvitationRepositoryInterface;
use CongregationManager\Component\User\Domain\Generator\TokenGeneratorInterface;

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
