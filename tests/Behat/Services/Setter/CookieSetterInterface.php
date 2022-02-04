<?php

namespace App\Tests\Behat\Services\Setter;

interface CookieSetterInterface
{
    public function setCookie(string $name, string $value): void;
}
