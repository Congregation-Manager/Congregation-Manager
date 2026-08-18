<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface;

interface AppUserFactoryInterface
{
    public function createNew(
        BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AppUserInterface;
}
