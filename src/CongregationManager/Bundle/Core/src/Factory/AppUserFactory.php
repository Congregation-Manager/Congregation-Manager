<?php

declare(strict_types=1);

namespace CongregationManager\Bundle\Core\Factory;

use CongregationManager\Bundle\Core\Entity\AppUser;
use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\Core\Domain\AppUserInterface;
use CongregationManager\Component\Core\Domain\Factory\AppUserFactoryInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class AppUserFactory implements AppUserFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AppUserInterface {
        return new AppUser($this->idGenerator->generateNew(), $brother, $email, $password, $localeCode);
    }
}
