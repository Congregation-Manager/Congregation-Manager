<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

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

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }
}
