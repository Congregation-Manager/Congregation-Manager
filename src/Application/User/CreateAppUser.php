<?php

declare(strict_types=1);

namespace CongregationManager\Application\User;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;
use CongregationManager\Domain\User\Hasher\UserPasswordHasherInterface;
use CongregationManager\Domain\User\Model\AppUser;
use CongregationManager\Domain\User\Model\AppUserInterface;
use CongregationManager\Domain\User\Repository\AppUserRepositoryInterface;

final class CreateAppUser
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
