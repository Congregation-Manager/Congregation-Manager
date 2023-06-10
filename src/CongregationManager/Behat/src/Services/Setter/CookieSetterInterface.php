<?php

declare(strict_types=1);

namespace CongregationManager\Behat\Services\Setter;

interface CookieSetterInterface
{
    public function setCookie(string $name, string $value): void;
}
