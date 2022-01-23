<?php

namespace App\Tests\Behat\Services;

interface EmailCheckerInterface
{
    public function hasMessageTo(string $message, string $recipient): bool;
}
