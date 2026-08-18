<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Application;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Component\Core\Domain\Factory\AppUserFactoryInterface;
use CongregationManager\Component\Core\Domain\Repository\AppUserRepositoryInterface;
use CongregationManager\Component\User\Domain\Hasher\UserPasswordHasherInterface;

final readonly class CreateAppUser
{
    /**
     * @phpstan-param AppUserRepositoryInterface<covariant AppUserInterface> $appUserRepository
     * @psalm-param AppUserRepositoryInterface<AppUserInterface> $appUserRepository
     */
    public function __construct(
        private AppUserFactoryInterface $appUserFactory,
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
        $appUser = $this->appUserFactory->createNew($brother, $email, null, $localeCode);
        if ($plainPassword !== null) {
            $appUser->setPassword($this->userPasswordHasher->hashPasswordForUser($plainPassword, $appUser));
        }
        $this->appUserRepository->add($appUser);

        return $appUser;
    }
}
