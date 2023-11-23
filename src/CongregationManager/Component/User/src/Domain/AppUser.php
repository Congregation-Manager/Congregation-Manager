<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Contract\Resource\Id;

class AppUser extends User implements AppUserInterface
{
    public function __construct(
        protected Id $id,
        protected BrotherInterface $brother,
        string $email,
        ?string $password = null,
        ?string $localeCode = null
    ) {
        parent::__construct($id, $email, $password, $localeCode);
    }

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }
}
