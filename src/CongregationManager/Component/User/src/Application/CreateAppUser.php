<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Application;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\AppUser;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserRepositoryInterface;

final readonly class CreateAppUser
{
    public function __construct(
        private AppUserRepositoryInterface $appUserRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    public function create(
        BrotherInterface $brother,
        string $email,
        ?string $plainPassword = null,
        ?string $localeCode = null
    ): AppUserInterface {
        $appUser = new AppUser($brother, $email, null, $localeCode);
        if ($plainPassword !== null) {
            $appUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $appUser));
        }
        $this->appUserRepository->add($appUser);

        return $appUser;
    }
}
