<?php

declare(strict_types=1);

namespace CongregationManager\Component\User\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;

interface AppUserInterface extends UserInterface
{
    public function getBrother(): BrotherInterface;
}
