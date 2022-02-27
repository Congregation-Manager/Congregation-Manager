<?php

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

class AppUser extends User implements AppUserInterface
{
    public function __construct(
        protected BrotherInterface $brother,
        string $email
    ) {
        parent::__construct($email);
    }

    public static function create(
        BrotherInterface $brother,
        string $email
    ): AppUserInterface {
        return new self($brother, $email);
    }

    public function getBrother(): BrotherInterface
    {
        return $this->brother;
    }
}
