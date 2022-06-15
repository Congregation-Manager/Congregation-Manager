<?php

declare(strict_types=1);

namespace CongregationManager\Tests\Behat\Services;

interface EmailCheckerInterface
{
    public function hasMessageTo(string $message, string $recipient): bool;
}
