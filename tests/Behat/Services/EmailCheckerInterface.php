<?php

namespace CongregationManager\Tests\Behat\Services;

interface EmailCheckerInterface
{
    public function hasMessageTo(string $message, string $recipient): bool;
}
