<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\UIUser;

class AppUser extends UIUser implements AppUserInterface
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
