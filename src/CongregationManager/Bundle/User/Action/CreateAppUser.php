<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Action;

use CongregationManager\Bundle\User\Model\AppUser;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\AppUserInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;
use CongregationManager\Component\User\Domain\Repository\AppUserRepositoryInterface;

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
        ?string $localeCode = null,
        ?string $hashedPassword = null
    ): AppUserInterface {
        $appUser = new AppUser($brother, $email, $hashedPassword, $localeCode);
        if ($hashedPassword === null && $plainPassword !== null) {
            $appUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $appUser));
        }
        $this->appUserRepository->add($appUser);

        return $appUser;
    }
}
