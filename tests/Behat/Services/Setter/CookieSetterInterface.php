<?php

namespace CongregationManager\Tests\Behat\Services\Setter;

interface CookieSetterInterface
{
    public function setCookie(string $name, string $value): void;
}
