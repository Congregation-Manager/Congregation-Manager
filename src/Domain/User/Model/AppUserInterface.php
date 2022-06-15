<?php

declare(strict_types=1);

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

interface AppUserInterface extends UserInterface
{
    public function getBrother(): BrotherInterface;
}
