<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain\Factory;

use CongregationManager\Component\Core\Domain\AdminUser;
use CongregationManager\Component\Core\Domain\AdminUserInterface;
use CongregationManager\Contract\Resource\IdGeneratorInterface;

final readonly class AdminUserFactory implements AdminUserFactoryInterface
{
    public function __construct(
        private IdGeneratorInterface $idGenerator
    ) {
    }

    #[\Override]
    public function createNew(
        string $email,
        ?string $password = null,
        ?string $localeCode = null,
    ): AdminUserInterface {
        return new AdminUser($this->idGenerator->generateNew(), $email, $password, $localeCode);
    }
}
