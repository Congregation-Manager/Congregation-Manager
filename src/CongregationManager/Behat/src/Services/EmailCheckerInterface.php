<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services;

interface EmailCheckerInterface
{
    public function hasMessageTo(string $message, string $recipient): bool;
}
