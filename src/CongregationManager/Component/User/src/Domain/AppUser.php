<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;

class AppUser extends User implements AppUserInterface
{
    public function __construct(
        protected BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null
    ) {
        parent::__construct($email, $password, $localeCode);
    }

    #[\Override]
    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }
}
