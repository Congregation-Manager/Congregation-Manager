<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\User\Action;

use CongregationManager\Bundle\Core\Entity\AppUIUserInterface;
use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\Repository\AppUserRepositoryInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;

final readonly class CreateAppUser
{
    /**
     * @phpstan-param AppUserRepositoryInterface<covariant AppUIUserInterface> $appUserRepository
     * @psalm-param AppUserRepositoryInterface<AppUIUserInterface> $appUserRepository
     */
    public function __construct(
        private AppUserRepositoryInterface $appUserRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
    ) {
    }

    public function create(
        BrotherInterface $brother,
        string $email,
        ?string $plainPassword = null,
        ?string $localeCode = null,
        ?string $hashedPassword = null
    ): AppUIUserInterface {
        $appUser = new AppUser($brother, $email, $hashedPassword, $localeCode);
        if ($hashedPassword === null && $plainPassword !== null) {
            $appUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $appUser));
        }
        $this->appUserRepository->add($appUser);

        return $appUser;
    }
}
