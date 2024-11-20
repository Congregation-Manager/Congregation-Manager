<?php

declare(strict_types=1);

namespace CongregationManager\Component\Core\Domain;

use CongregationManager\Component\Congregation\Domain\BrotherInterface;
use CongregationManager\Component\User\Domain\UIUserInterface;

interface AppUserInterface extends UIUserInterface
{
    public function getBrother(): BrotherInterface;
}
