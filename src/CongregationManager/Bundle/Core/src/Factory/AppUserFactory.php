<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Factory;

use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Component\Core\Domain\Factory\AppUserFactoryInterface;

final class AppUserFactory implements AppUserFactoryInterface
{
    #[\Override]
    public function createNew(
        BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AppUserInterface {
        return new AppUser($brother, $email, $password, $localeCode);
    }
}
