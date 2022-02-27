<?php

namespace CongregationManager\Domain\User\Model;

use CongregationManager\Domain\Congregation\Model\BrotherInterface;

interface AppUserInterface extends UserInterface
{
    public function getBrother(): BrotherInterface;
}
