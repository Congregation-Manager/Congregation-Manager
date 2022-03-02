<?php

declare(strict_types=1);

namespace CongregationManager\Application\User;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\User\Model\AppUser;
use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Repository\AppUserRepositoryInterface;

final class CreateAppUser
{
    public function __construct(
        private AppUserRepositoryInterface $appUserRepository
    ) {
    }

    public function create(
        BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null
    ): AppUserInterface {
        $appUser = new AppUser($brother, $email, $password, $localeCode);
        $this->appUserRepository->add($appUser);

        return $appUser;
    }
}
